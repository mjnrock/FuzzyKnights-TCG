USE FuzzyKnights
GO

--	CREATE SCHEMA TCG
--	GO

--	==============================================
--		SMART DROP
--	==============================================
DECLARE @Schema VARCHAR(255) = 'TCG';
DECLARE @SQL NVARCHAR(MAX) = '';

SELECT
	@SQL = @SQL + 'ALTER TABLE ['+s.name+'].['+t.name+'] DROP CONSTRAINT ['+o.name+'];'
FROM
	sys.foreign_key_columns fkc
	INNER JOIN sys.objects o
		ON fkc.constraint_object_id = o.object_id
	INNER JOIN sys.tables t
		ON fkc.parent_object_id = t.object_id
	INNER JOIN sys.schemas s
		ON t.schema_id = s.schema_id
WHERE
	s.name = @Schema
EXEC(@SQL);

SET @SQL = '';
SELECT
	@SQL = @SQL + 'IF OBJECT_ID('''+s.name+'.['+t.name+']'') IS NOT NULL DROP TABLE '+s.name+'.['+t.name+'];'
FROM
	sys.tables t
	INNER JOIN sys.schemas s
		ON t.schema_id = s.schema_id
WHERE
	s.name = @Schema
EXEC(@SQL);

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



CREATE TABLE TCG.Stat (
	StatID INT IDENTITY(1,1) PRIMARY KEY,

	Short VARCHAR(255) NULL,
	Label VARCHAR(255) NOT NULL,
	[Description] VARCHAR(MAX) NULL,
		
	CreatedDateTime DATETIME2(3) NOT NULL DEFAULT SYSDATETIME(),
	ModifiedDateTime DATETIME2(3) NOT NULL DEFAULT SYSDATETIME(),
	DeactivatedDateTime DATETIME2(3) NULL
);

CREATE TABLE TCG.[Card] (
	CardID INT IDENTITY(1,1) PRIMARY KEY,

	Name VARCHAR(255) NOT NULL,
	Picture VARCHAR(255) NULL,
	
	CreatedDateTime DATETIME2(3) NOT NULL DEFAULT SYSDATETIME(),
	ModifiedDateTime DATETIME2(3) NOT NULL DEFAULT SYSDATETIME(),
	DeactivatedDateTime DATETIME2(3) NULL
);

CREATE TABLE TCG.CardStat (
	CardStatID INT IDENTITY(1,1) PRIMARY KEY,
	
	CardID INT NOT NULL FOREIGN KEY REFERENCES TCG.[Card] (CardID),
	StatID INT NOT NULL FOREIGN KEY REFERENCES TCG.Stat (StatID),
	Value REAL NOT NULL,
	
	CreatedDateTime DATETIME2(3) NOT NULL DEFAULT SYSDATETIME(),
	ModifiedDateTime DATETIME2(3) NOT NULL DEFAULT SYSDATETIME(),
	DeactivatedDateTime DATETIME2(3) NULL
);

CREATE TABLE TCG.StatAction (
	StatActionID INT IDENTITY(1,1) PRIMARY KEY,

	Short VARCHAR(255) NULL,
	Label VARCHAR(255) NOT NULL,
	[Description] VARCHAR(MAX) NULL,
		
	CreatedDateTime DATETIME2(3) NOT NULL DEFAULT SYSDATETIME(),
	ModifiedDateTime DATETIME2(3) NOT NULL DEFAULT SYSDATETIME(),
	DeactivatedDateTime DATETIME2(3) NULL
);

CREATE TABLE TCG.Task (
	TaskID INT IDENTITY(1,1) PRIMARY KEY,

	Short VARCHAR(255) NULL,
	Label VARCHAR(255) NOT NULL,
	[Description] VARCHAR(MAX) NULL,
		
	CreatedDateTime DATETIME2(3) NOT NULL DEFAULT SYSDATETIME(),
	ModifiedDateTime DATETIME2(3) NOT NULL DEFAULT SYSDATETIME(),
	DeactivatedDateTime DATETIME2(3) NULL
);

CREATE TABLE TCG.CardType (
	CardTypeID INT IDENTITY(1,1) PRIMARY KEY,

	Short VARCHAR(255) NULL,
	Label VARCHAR(255) NOT NULL,
	[Description] VARCHAR(MAX) NULL,
		
	CreatedDateTime DATETIME2(3) NOT NULL DEFAULT SYSDATETIME(),
	ModifiedDateTime DATETIME2(3) NOT NULL DEFAULT SYSDATETIME(),
	DeactivatedDateTime DATETIME2(3) NULL
);

CREATE TABLE TCG.Discipline (
	DisciplineID INT IDENTITY(1,1) PRIMARY KEY,

	Short VARCHAR(255) NULL,
	Label VARCHAR(255) NOT NULL,
	[Description] VARCHAR(MAX) NULL,
		
	CreatedDateTime DATETIME2(3) NOT NULL DEFAULT SYSDATETIME(),
	ModifiedDateTime DATETIME2(3) NOT NULL DEFAULT SYSDATETIME(),
	DeactivatedDateTime DATETIME2(3) NULL
);

CREATE TABLE TCG.CardCategorization (
	CardCategorizationID INT IDENTITY(1,1) PRIMARY KEY,
	
	CardID INT NOT NULL FOREIGN KEY REFERENCES TCG.[Card] (CardID),
	TaskID INT NOT NULL FOREIGN KEY REFERENCES TCG.Task (TaskID),
	CardTypeID INT NOT NULL FOREIGN KEY REFERENCES TCG.CardType (CardTypeID),
	DisciplineID INT NOT NULL FOREIGN KEY REFERENCES TCG.Discipline (DisciplineID),
	
	RequirementCardTypeID INT NULL FOREIGN KEY REFERENCES TCG.CardType (CardTypeID),
	
	CreatedDateTime DATETIME2(3) NOT NULL DEFAULT SYSDATETIME(),
	ModifiedDateTime DATETIME2(3) NOT NULL DEFAULT SYSDATETIME(),
	DeactivatedDateTime DATETIME2(3) NULL
);

CREATE TABLE TCG.[Target] (
	TargetID INT IDENTITY(1,1) PRIMARY KEY,

	X INT NOT NULL,
	Y INT NOT NULL,
	IsFriendly BIT NOT NULL,
	Short VARCHAR(255) NULL,
	Label VARCHAR(255) NULL,
	[Description] VARCHAR(MAX) NULL,
		
	CreatedDateTime DATETIME2(3) NOT NULL DEFAULT SYSDATETIME(),
	ModifiedDateTime DATETIME2(3) NOT NULL DEFAULT SYSDATETIME(),
	DeactivatedDateTime DATETIME2(3) NULL
);

CREATE TABLE TCG.CardStatModifier (
	CardStatModifierID INT IDENTITY(1,1) PRIMARY KEY,
	
	CardID INT NOT NULL FOREIGN KEY REFERENCES TCG.[Card] (CardID),
	StatID INT NOT NULL FOREIGN KEY REFERENCES TCG.Stat (StatID),
	StatActionID INT NOT NULL FOREIGN KEY REFERENCES TCG.StatAction (StatActionID),	
	TargetID INT NOT NULL FOREIGN KEY REFERENCES TCG.[Target] (TargetID),

	Lifespan REAL NOT NULL DEFAULT 0,
	Number REAL NOT NULL DEFAULT 0,
	Sided REAL NOT NULL DEFAULT 0,
	Bonus REAL NOT NULL DEFAULT 0,
	
	Stage INT NULL DEFAULT 1,
	Step INT NULL DEFAULT 1,
	
	CreatedDateTime DATETIME2(3) NOT NULL DEFAULT SYSDATETIME(),
	ModifiedDateTime DATETIME2(3) NOT NULL DEFAULT SYSDATETIME(),
	DeactivatedDateTime DATETIME2(3) NULL
);




--	==============================================
--		SEEDING
--	==============================================
INSERT INTO TCG.Stat (Short, Label) VALUES
('STR', 'Strength'),
('TGH', 'Toughness'),
('PWR', 'Power'),
('RES', 'Resistance'),
('HP', 'Health'),
('MP', 'Mana'),
('DUR', 'Durability');

INSERT INTO TCG.[Card] (Name) VALUES
('Wooden Shield'),
('Stone Shield'),
('Bronze Shield'),
('Aura'),
('Block'),
('Slash'),
('Health Potion'),
('Hero'),
('Heal'),
('Fireball'),
('Magic Missile'),
('Wooden Sword'),
('Stone Sword'),
('Bronze Sword'),
('Cloth Armor'),
('Leather Armor'),
('Bronze Armor');

INSERT INTO TCG.StatAction (Short, Label) VALUES
('Base', 'Base'),
('Buff', 'Buff'),
('Debuff', 'Debuff'),
('+', 'Add'),
('-', 'Reduce'),
('*', 'Multiply'),
('/', 'Divide');

INSERT INTO TCG.[Target] (X, Y, IsFriendly, Short, Label) VALUES
(0, 0, 1, 'F0', 'Actor'),
(1, 0, 1, 'F1R', 'Friendly Right 1'),
(2, 0, 1, 'F2R', 'Friendly Right 2'),
(-1, 0, 1, 'F1L', 'Friendly Left 1'),
(-2, 0, 1, 'F2L', 'Friendly Left 2'),
(0, 1, 0, 'E0', 'Facing'),
(1, 1, 0, 'E1R', 'Enemy Right 1'),
(2, 1, 0, 'E2R', 'Enemy Right 2'),
(-1, 1, 0, 'E1L', 'Enemy Left 1'),
(-2, 1, 0, 'E2L', 'Enemy Left 2'),
(0, 0, 1, 'S', 'Self');

INSERT INTO TCG.Task (Short, Label) VALUES
('I', 'Item'),
('Q', 'Equipment'),
('A', 'Action'),
('E', 'Entity');

INSERT INTO TCG.CardType (Short, Label) VALUES
('OFF', 'Offensive'),
('DEF', 'Defensive'),
('UTL', 'Utility'),
('HRO', 'Hero'),
('ENT', 'Entity'),
('SWD', 'Sword'),
('SHD', 'Shield'),
('ARM', 'Armor'),
('AUR', 'Aura'),
('POT', 'Potion'),
('BOK', 'Book'),
('WND', 'Wand');

INSERT INTO TCG.Discipline (Short, Label) VALUES
('P', 'Physical'),
('M', 'Magical'),
('H', 'Hybrid');

INSERT INTO TCG.CardStatModifier (CardID, StatID, StatActionID, TargetID, Lifespan, Number, Sided, Bonus, Stage, Step) VALUES
(1, 2, 2, 1, -1, 0, 0, 1, 1, 1),
(2, 2, 2, 1, -1, 0, 0, 2, 1, 1),
(3, 2, 2, 1, -1, 0, 0, 3, 1, 1),
(4, 6, 5, 1, -1, 0, 0, 1, 1, 1),
(4, 1, 2, 1, -1, 0, 0, 1, 2, 1),
(4, 3, 2, 1, -1, 0, 0, 1, 2, 2),
(5, 2, 2, 1, 1, 1, 3, 1, 1, 1),
(6, 1, 2, 1, 0, 1, 3, 0, 1, 1),
(6, 5, 5, 6, 0, 0, 0, 0, 2, 1),
(6, 5, 5, 7, 0, 0, 0, -1, 2, 2),
(6, 5, 5, 8, 0, 0, 0, -2, 2, 3),
(7, 5, 4, 1, 0, 1, 3, 2, 1, 1),
(8, 5, 4, 1, -1, 0, 0, 1, 2, 1),
(8, 6, 4, 1, -1, 0, 0, 1, 2, 2),
(9, 6, 5, 1, 0, 0, 0, 1, 1, 1),
(9, 5, 4, 1, 0, 1, 3, 1, 2, 1),
(10, 6, 5, 1, 0, 0, 0, 1, 1, 1),
(10, 3, 2, 1, 0, 1, 4, 0, 1, 1),
(10, 5, 5, 6, 0, 0, 0, 0, 2, 1),
(10, 5, 5, 7, 0, 0, 0, -4, 3, 1),
(10, 5, 5, 9, 0, 0, 0, -4, 3, 2),
(11, 6, 5, 1, 0, 0, 0, 1, 1, 1),
(11, 3, 2, 1, 0, 3, 2, 0, 2, 1),
(11, 5, 5, 6, 0, 0, 0, 0, 3, 1),
(12, 1, 2, 1, -1, 0, 0, 1, 1, 1),
(13, 1, 2, 1, -1, 0, 0, 2, 1, 1),
(14, 1, 2, 1, -1, 0, 0, 3, 1, 1),
(15, 2, 2, 1, -1, 0, 0, 1, 1, 1),
(15, 4, 2, 1, -1, 0, 0, 1, 1, 2),
(16, 2, 2, 1, -1, 0, 0, 2, 1, 1),
(16, 4, 2, 1, -1, 0, 0, 2, 1, 2),
(17, 2, 2, 1, -1, 0, 0, 3, 1, 1),
(17, 4, 2, 1, -1, 0, 0, 3, 1, 2);

INSERT INTO TCG.CardStat (CardID, StatID, Value)
VALUES
(4, 1, 0),
(4, 2, 0),
(4, 3, 0),
(4, 6, 0),
(4, 7, 0),
(4, 5, 0),
(4, 4, 0),

(5, 1, 0),
(5, 2, 0),
(5, 3, 0),
(5, 6, 0),
(5, 7, 0),
(5, 5, 0),
(5, 4, 0),

(17, 1, 0),
(17, 2, 0),
(17, 3, 0),
(17, 6, 0),
(17, 7, 4),
(17, 5, 0),
(17, 4, 0),

(3, 1, 0),
(3, 2, 0),
(3, 3, 0),
(3, 6, 0),
(3, 7, 3),
(3, 5, 0),
(3, 4, 0),

(14, 1, 0),
(14, 2, 0),
(14, 3, 0),
(14, 6, 0),
(14, 7, 4),
(14, 5, 0),
(14, 4, 0),

(15, 1, 0),
(15, 2, 0),
(15, 3, 0),
(15, 6, 0),
(15, 7, 2),
(15, 5, 0),
(15, 4, 0),

(10, 1, 0),
(10, 2, 0),
(10, 3, 0),
(10, 6, 0),
(10, 7, 0),
(10, 5, 0),
(10, 4, 0),

(9, 1, 0),
(9, 2, 0),
(9, 3, 0),
(9, 6, 0),
(9, 7, 0),
(9, 5, 0),
(9, 4, 0),

(7, 1, 0),
(7, 2, 0),
(7, 3, 0),
(7, 6, 0),
(7, 7, 0),
(7, 5, 0),
(7, 4, 0),

(8, 1, 3),
(8, 2, 2),
(8, 3, 0),
(8, 6, 1),
(8, 7, 0),
(8, 5, 15),
(8, 4, 0),

(16, 1, 0),
(16, 2, 0),
(16, 3, 0),
(16, 6, 0),
(16, 7, 3),
(16, 5, 0),
(16, 4, 0),

(11, 1, 0),
(11, 2, 0),
(11, 3, 0),
(11, 6, 0),
(11, 7, 0),
(11, 5, 0),
(11, 4, 0),

(6, 1, 0),
(6, 2, 0),
(6, 3, 0),
(6, 6, 0),
(6, 7, 0),
(6, 5, 0),
(6, 4, 0),

(2, 1, 0),
(2, 2, 0),
(2, 3, 0),
(2, 6, 0),
(2, 7, 2),
(2, 5, 0),
(2, 4, 0),

(13, 1, 0),
(13, 2, 0),
(13, 3, 0),
(13, 6, 0),
(13, 7, 3),
(13, 5, 0),
(13, 4, 0),

(1, 1, 0),
(1, 2, 0),
(1, 3, 0),
(1, 6, 0),
(1, 7, 1),
(1, 5, 0),
(1, 4, 0),

(12, 1, 0),
(12, 2, 0),
(12, 3, 0),
(12, 6, 0),
(12, 7, 2),
(12, 5, 0),
(12, 4, 0);

INSERT INTO TCG.CardCategorization (CardID, CardTypeID, TaskID, DisciplineID, RequirementCardTypeID)
VALUES
(4, 9, 3, 1, NULL),
(5, 2, 3, 1, 7),
(17, 8, 2, 3, NULL),
(3, 7, 2, 2, NULL),
(14, 6, 2, 3, NULL),
(15, 8, 2, 3, NULL),
(10, 1, 3, 2, 12),
(9, 3, 3, 2, 11),
(7, 10, 1, 3, NULL),
(8, 4, 4, 2, NULL),
(16, 8, 2, 3, NULL),
(11, 1, 3, 1, 12),
(6, 1, 3, 2, 6),
(2, 7, 2, 1, NULL),
(13, 6, 2, 1, NULL),
(1, 7, 2, 1, NULL),
(12, 6, 2, 1, NULL);



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



CREATE PROCEDURE TCG.QuickCreateCard
AS
BEGIN
	SET NOCOUNT ON;

	DECLARE @Card TABLE (CardID INT, CardStatID INT, CardCategorizationID INT, CardStatModifierID INT);

	INSERT INTO TCG.[Card] (Name, DeactivatedDateTime)
	OUTPUT
		Inserted.CardID INTO @Card (CardID)
	VALUES
		(CAST(NEWID() AS VARCHAR(255)), GETDATE());

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