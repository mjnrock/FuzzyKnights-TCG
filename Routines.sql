USE FuzzyKnights
GO

--	CREATE SCHEMA TCG
--	GO

--	==============================================
--		SMART DROP
--	==============================================
DECLARE @Schema VARCHAR(255) = 'TCG';
DECLARE @SQL NVARCHAR(MAX) = '';

SET @SQL = '';
SELECT
	@SQL = @SQL + 'IF OBJECT_ID('''+s.name+'.['+v.name+']'') IS NOT NULL DROP VIEW '+s.name+'.['+v.name+'];'
FROM
	sys.views v
	INNER JOIN sys.schemas s
		ON v.schema_id = s.schema_id
WHERE
	s.name = @Schema
EXEC(@SQL);

SET @SQL = '';
SELECT
	@SQL = @SQL + 'DROP PROCEDURE [' + routine_schema + '].[' + routine_name + ']'
FROM 
    information_schema.routines
WHERE
	routine_schema = @Schema
	AND routine_type = 'PROCEDURE'
EXEC(@SQL);

SET @SQL = '';
SELECT
	@SQL = @SQL + 'DROP FUNCTION [' + routine_schema + '].[' + routine_name + ']'
FROM 
    information_schema.routines
WHERE
	routine_schema = @Schema
	AND routine_type = 'FUNCTION'
EXEC(@SQL);
GO


--	==============================================
--		VIEWS
--	==============================================
CREATE VIEW TCG.vwCardStatModifier AS
SELECT
	c.Name,
	c.Picture,
	c.CardID,
	CASE
		WHEN c.DeactivatedDateTime IS NULL THEN 1
		ELSE 0
	END AS IsActive,
	cc.*,
	s.StatID,
	s.Short AS StatShort,
	s.Label AS StatLabel,
	sa.Short AS StatActionShort,
	sa.Label AS StatActionLabel,
	t.TargetID,
	t.X,
	t.Y,
	t.IsFriendly,
	t.Short AS TargetShort,
	t.Label AS TargetLabel,
	csm.CardStatModifierID,
	csm.Lifespan,
	csm.Number,
	csm.Sided,
	csm.Bonus,
	csm.Stage,
	csm.Step,
	CASE
		WHEN csm.DeactivatedDateTime IS NULL THEN 1
		ELSE 0
	END AS ModifierIsActive,
	cs.*
FROM
	TCG.[Card] c WITH (NOLOCK)
	INNER JOIN TCG.CardStatModifier csm WITH (NOLOCK)
		ON c.CardID = csm.CardID
	INNER JOIN TCG.Stat s WITH (NOLOCK)
		ON csm.StatID = s.StatID
	INNER JOIN TCG.StatAction sa WITH (NOLOCK)
		ON csm.StatActionID = sa.StatActionID
	INNER JOIN TCG.[Target] t WITH (NOLOCK)
		ON csm.TargetID = t.TargetID
	INNER JOIN (
		SELECT
			cc.CardID AS CardCategorizationCardID,
			t.TaskID,
			t.Short AS TaskShort,
			t.Label AS TaskLabel,
			ct.CardTypeID,
			ct.Short AS CardTypeShort,
			ct.Label AS CardTypeLabel,
			d.DisciplineID,
			d.Short AS DisciplineShort,
			d.Label AS DisciplineLabel,
			ctr.CardTypeID AS RequirementCardTypeID,
			ctr.Short AS RequirementCardTypeShort,
			ctr.Label AS RequirementCardTypeLabel
		FROM
			TCG.CardCategorization cc WITH (NOLOCK)
			INNER JOIN TCG.CardType ct WITH (NOLOCK)
				ON cc.CardTypeID = ct.CardTypeID
			INNER JOIN TCG.Task t WITH (NOLOCK)
				ON cc.TaskID = t.TaskID
			INNER JOIN TCG.Discipline d WITH (NOLOCK)
				ON cc.DisciplineID = d.DisciplineID
			LEFT JOIN TCG.CardType ctr WITH (NOLOCK)
				ON cc.RequirementCardTypeID = ctr.CardTypeID
	) cc
		ON c.CardID = cc.CardCategorizationCardID
	FULL OUTER JOIN (
		SELECT
			CardID AS CardStatCardID,
			MAX(CASE
				WHEN StatID = 1 THEN Value
				ELSE 0
			END) AS Strength,
			MAX(CASE
				WHEN StatID = 2 THEN Value
				ELSE 0
			END) AS Toughness,
			MAX(CASE
				WHEN StatID = 3 THEN Value
				ELSE 0
			END) AS 'Power',
			MAX(CASE
				WHEN StatID = 4 THEN Value
				ELSE 0
			END) AS Resistance,
			MAX(CASE
				WHEN StatID = 5 THEN Value
				ELSE 0
			END) AS Health,
			MAX(CASE
				WHEN StatID = 6 THEN Value
				ELSE 0
			END) AS Mana,
			MAX(CASE
				WHEN StatID = 7 THEN Value
				ELSE 0
			END) AS 'Durability'
		FROM
			TCG.CardStat cs WITH (NOLOCK)
		GROUP BY
			CardID
	) cs
		ON
			c.CardID = cs.CardStatCardID
GO

CREATE VIEW TCG.vwDeck AS
SELECT
	d.DeckID,
	d.Name,
	d.[Description],
	CASE
		WHEN d.DeactivatedDateTime IS NULL THEN 1
		ELSE 0
	END AS IsActive,

	dcm.UniqueCardCount,
	dcm.TotalCardCount
FROM
	TCG.Deck d WITH (NOLOCK)
	LEFT JOIN TCG.DeckCard dc WITH (NOLOCK)
		ON d.DeckID = dc.DeckID
	LEFT JOIN (
		SELECT
			dc2.DeckID,
			COUNT(DISTINCT dc2.CardID) AS UniqueCardCount,
			SUM(Quantity) AS TotalCardCount
		FROM
			TCG.DeckCard dc2 WITH (NOLOCK)
		GROUP BY
			dc2.DeckID
	) dcm
		ON d.DeckID = dcm.DeckID
GO

CREATE VIEW TCG.vwAnomalyFinder AS
SELECT DISTINCT
	*
FROM (
		--SELECT
		--	csm.*,
		--	'0-Turn Lifespan' AS AnomalyMessage
		--FROM
		--	TCG.vwCardStatModifier csm WITH (NOLOCK)
		--WHERE
		--	csm.TaskShort = 'A'
		--	AND csm.Lifespan = 0

		--UNION ALL

		--SELECT
		--	csm.*,
		--	'Non 0-Turn Lifespan' AS AnomalyMessage
		--FROM
		--	TCG.vwCardStatModifier csm WITH (NOLOCK)
		--WHERE
		--	csm.TaskShort = 'A'
		--	AND csm.Lifespan != 0

		--UNION ALL

		SELECT
			csm.*,
			'Equipment, Non-Positive Durability' AS AnomalyMessage
		FROM
			TCG.vwCardStatModifier csm WITH (NOLOCK)
		WHERE
			csm.TaskShort = 'Q'
			AND csm.[Durability] <= 0

		UNION ALL

		SELECT
			csm.*,
			'Equipment, No Requirement' AS AnomalyMessage
		FROM
			TCG.vwCardStatModifier csm WITH (NOLOCK)
		WHERE
			csm.TaskShort = 'Q'
			AND csm.RequirementCardTypeID IS NOT NULL

		UNION ALL

		SELECT
			csm.*,
			'Action, No Requirement' AS AnomalyMessage
		FROM
			TCG.vwCardStatModifier csm	 WITH (NOLOCK)
		WHERE
			csm.TaskShort = 'A'
			AND csm.RequirementCardTypeID IS NULL

		UNION ALL

		SELECT
			csm.*,
			'Identical Stage/Step' AS AnomalyMessage
		FROM
			TCG.vwCardStatModifier csm WITH (NOLOCK)
		WHERE
			EXISTS (
				SELECT
					*
				FROM
					TCG.vwCardStatModifier csm2 WITH (NOLOCK)
				WHERE
					csm.CardID = csm2.CardID
					AND csm.CardStatModifierID != csm2.CardStatModifierID
					AND (
						csm.Stage = csm2.Stage
						AND csm.Step = csm2.Step
					)
			)
	) v
GO







CREATE FUNCTION [TCG].[GetCard]
(	
	@CardID INT
)
RETURNS TABLE 
AS
RETURN 
(
	SELECT
		c.Name,
		c.Picture,
		c.CardID,
		CASE
			WHEN c.DeactivatedDateTime IS NULL THEN 1
			ELSE 0
		END AS IsActive,
		cc.*,
		s.StatID,
		s.Short AS StatShort,
		s.Label AS StatLabel,
		sa.Short AS StatActionShort,
		sa.Label AS StatActionLabel,
		t.TargetID,
		t.X,
		t.Y,
		t.IsFriendly,
		t.Short AS TargetShort,
		t.Label AS TargetLabel,
		csm.CardStatModifierID,
		csm.Lifespan,
		csm.Number,
		csm.Sided,
		csm.Bonus,
		csm.Stage,
		csm.Step,
		CASE
			WHEN csm.DeactivatedDateTime IS NULL THEN 1
			ELSE 0
		END AS ModifierIsActive,
		cs.*
	FROM
		TCG.[Card] c WITH (NOLOCK)
		INNER JOIN TCG.CardStatModifier csm WITH (NOLOCK)
			ON c.CardID = csm.CardID
		INNER JOIN TCG.Stat s WITH (NOLOCK)
			ON csm.StatID = s.StatID
		INNER JOIN TCG.StatAction sa WITH (NOLOCK)
			ON csm.StatActionID = sa.StatActionID
		INNER JOIN TCG.[Target] t WITH (NOLOCK)
			ON csm.TargetID = t.TargetID
		INNER JOIN (
			SELECT
				cc.CardID AS CardCategorizationCardID,
				t.TaskID,
				t.Short AS TaskShort,
				t.Label AS TaskLabel,
				ct.CardTypeID,
				ct.Short AS CardTypeShort,
				ct.Label AS CardTypeLabel,
				d.DisciplineID,
				d.Short AS DisciplineShort,
				d.Label AS DisciplineLabel,
				ctr.CardTypeID AS RequirementCardTypeID,
				ctr.Short AS RequirementCardTypeShort,
				ctr.Label AS RequirementCardTypeLabel
			FROM
				TCG.CardCategorization cc WITH (NOLOCK)
				INNER JOIN TCG.CardType ct WITH (NOLOCK)
					ON cc.CardTypeID = ct.CardTypeID
				INNER JOIN TCG.Task t WITH (NOLOCK)
					ON cc.TaskID = t.TaskID
				INNER JOIN TCG.Discipline d WITH (NOLOCK)
					ON cc.DisciplineID = d.DisciplineID
				LEFT JOIN TCG.CardType ctr WITH (NOLOCK)
					ON cc.RequirementCardTypeID = ctr.CardTypeID
		) cc
			ON c.CardID = cc.CardCategorizationCardID
		FULL OUTER JOIN (
			SELECT
				CardID AS CardStatCardID,
				MAX(CASE
					WHEN StatID = 1 THEN Value
					ELSE 0
				END) AS Strength,
				MAX(CASE
					WHEN StatID = 2 THEN Value
					ELSE 0
				END) AS Toughness,
				MAX(CASE
					WHEN StatID = 3 THEN Value
					ELSE 0
				END) AS 'Power',
				MAX(CASE
					WHEN StatID = 4 THEN Value
					ELSE 0
				END) AS Resistance,
				MAX(CASE
					WHEN StatID = 5 THEN Value
					ELSE 0
				END) AS Health,
				MAX(CASE
					WHEN StatID = 6 THEN Value
					ELSE 0
				END) AS Mana,
				MAX(CASE
					WHEN StatID = 7 THEN Value
					ELSE 0
				END) AS 'Durability'
			FROM
				TCG.CardStat cs WITH (NOLOCK)
			GROUP BY
				CardID
		) cs
			ON
				c.CardID = cs.CardStatCardID
	WHERE
		c.CardID = @CardID
)
GO

CREATE FUNCTION TCG.GetDeck
(	
	@DeckID INT
)
RETURNS TABLE 
AS
RETURN 
(
	SELECT
		d.DeckID,
		d.Name,
		d.[Description],
		CASE
			WHEN d.DeactivatedDateTime IS NULL THEN 1
			ELSE 0
		END AS IsActive,

		dcm.UniqueCardCount,
		dcm.TotalCardCount
	FROM
		TCG.Deck d WITH (NOLOCK)
		LEFT JOIN TCG.DeckCard dc WITH (NOLOCK)
			ON d.DeckID = dc.DeckID
		LEFT JOIN (
			SELECT
				dc2.DeckID,
				COUNT(DISTINCT dc2.CardID) AS UniqueCardCount,
				SUM(Quantity) AS TotalCardCount
			FROM
				TCG.DeckCard dc2 WITH (NOLOCK)
			GROUP BY
				dc2.DeckID
		) dcm
			ON d.DeckID = dcm.DeckID
	WHERE
		d.DeckID = @DeckID
)
GO

CREATE FUNCTION TCG.GetDeckCards
(	
	@DeckID INT
)
RETURNS TABLE 
AS
RETURN 
(
	SELECT
		dc.Quantity,
		ca.*
	FROM
		TCG.DeckCard dc WITH (NOLOCK)
		CROSS APPLY TCG.GetCard(dc.CardID) ca
	WHERE
		dc.DeckID = @DeckID
)
GO



CREATE PROCEDURE TCG.QuickCreateCard
AS
BEGIN
	SET NOCOUNT ON;

	DECLARE @Card TABLE (CardID INT, CardStatID INT, CardCategorizationID INT, CardStatModifierID INT);

	INSERT INTO TCG.[Card] (Name, DeactivatedDateTime)
	OUTPUT
		Inserted.CardID INTO @Card (CardID)
	VALUES
		(CAST(NEWID() AS VARCHAR(255)), SYSDATETIME());

	DECLARE @CardID INT = (SELECT CardID FROM @Card);


	INSERT INTO TCG.CardStat (CardID, StatID, Value)
	OUTPUT
		Inserted.CardStatID INTO @Card (CardStatID)
	SELECT
		@CardID,
		s.StatID,
		0
	FROM
		TCG.Stat s WITH (NOLOCK);


	INSERT INTO TCG.CardCategorization(CardID, TaskID, CardTypeID, DisciplineID, RequirementCardTypeID)
	OUTPUT
		Inserted.CardCategorizationID INTO @Card (CardCategorizationID)
	SELECT
		@CardID,
		1,
		1,
		1,
		NULL;


	INSERT INTO TCG.CardStatModifier (CardID, StatID, StatActionID, TargetID, Lifespan, Number, Sided, Bonus, Stage, Step)
	OUTPUT
		Inserted.CardStatModifierID INTO @Card (CardStatModifierID)
	VALUES
		(@CardID, 1, 1, 1, 0, 0, 0, 0, 99, 99);

	SELECT
		MAX(CardID) AS CardID,
		MAX(CardCategorizationID) AS CardCategorizationID,
		MAX(CardStatModifierID) AS CardStatModifierID
	FROM
		@Card;
END
GO

CREATE PROCEDURE TCG.DeleteCard
	@CardID INT
AS
BEGIN
	SET NOCOUNT ON;
	
    DELETE FROM TCG.CardStatModifier
	WHERE
		CardID = @CardID;
		
    DELETE FROM TCG.CardStat
	WHERE
		CardID = @CardID;
		
    DELETE FROM TCG.CardCategorization
	WHERE
		CardID = @CardID;

    DELETE FROM TCG.[Card]
	WHERE
		CardID = @CardID;

	SELECT
		@CardID AS CardID;
END
GO

CREATE PROCEDURE [TCG].[QuickCreateDeck]
AS
BEGIN
	SET NOCOUNT ON;

	INSERT INTO TCG.Deck (Name)
	OUTPUT
		Inserted.DeckID
	VALUES
		(CAST(NEWID() AS VARCHAR(255)));
END
GO

CREATE PROCEDURE TCG.DeleteDeck
	@DeckID INT
AS
BEGIN
	SET NOCOUNT ON;
	
    DELETE FROM TCG.DeckCard
	WHERE
		DeckID = @DeckID;
		
    DELETE FROM TCG.Deck
	WHERE
		DeckID = @DeckID;

	SELECT
		@DeckID AS DeckID;
END
GO