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

CREATE TABLE TCG.Deck (
	DeckID INT IDENTITY(1,1) PRIMARY KEY,

	Name VARCHAR(255) NOT NULL,
	[Description] VARCHAR(MAX) NULL,
	
	CreatedDateTime DATETIME2(3) NOT NULL DEFAULT SYSDATETIME(),
	ModifiedDateTime DATETIME2(3) NOT NULL DEFAULT SYSDATETIME(),
	DeactivatedDateTime DATETIME2(3) NULL
);

CREATE TABLE TCG.DeckCard (
	DeckCardID INT IDENTITY(1,1) PRIMARY KEY,
	
	DeckID INT NOT NULL FOREIGN KEY REFERENCES TCG.Deck (DeckID),
	CardID INT NOT NULL FOREIGN KEY REFERENCES TCG.[Card] (CardID),
	Quantity INT NOT NULL DEFAULT 1,
	Ordinality INT NULL,	-- In case you want to allow for a Deck to be played in a particular order
	
	CreatedDateTime DATETIME2(3) NOT NULL DEFAULT SYSDATETIME(),
	ModifiedDateTime DATETIME2(3) NOT NULL DEFAULT SYSDATETIME(),
	DeactivatedDateTime DATETIME2(3) NULL
);