CREATE TABLE Content(
    Title   	VARCHAR(50) PRIMARY KEY,
    Language    VARCHAR(25),
    Release_Date    DATE
);

CREATE TABLE Series(
    Title   	VARCHAR(50) PRIMARY KEY,
    GENRE    	VARCHAR(15),
    FOREIGN KEY (Title) REFERENCES Content ON DELETE CASCADE
);

CREATE TABLE Directors(
    Director   		VARCHAR(50) PRIMARY KEY,
    FavoriteSeries      VARCHAR(50) NOT NULL,
    FOREIGN KEY (FavoriteSeries) REFERENCES Series(Title) ON DELETE CASCADE
);

CREATE TABLE Countries(
    Country     VARCHAR(40) PRIMARY KEY,
    Region      VARCHAR(20),
    Population  INT,
    Area        INT
);

CREATE TABLE Actors(
    Actor   		VARCHAR(50) PRIMARY KEY,
    FavoriteCountry     VARCHAR(40) NOT NULL,
    FOREIGN KEY (FavoriteCountry) REFERENCES Countries(Country) ON DELETE CASCADE
);

CREATE TABLE Movies(
    Title   	VARCHAR(50) PRIMARY KEY,
    Revenues    INT,
    Director    VARCHAR(50) NOT NULL,
    FOREIGN KEY (Title) REFERENCES Content ON DELETE CASCADE,
    --FOREIGN KEY (Director) REFERENCES Directors ON DELETE CASCADE
);

CREATE TABLE ActedIn(
    Actor   	VARCHAR(50),
    Title   	VARCHAR(50),
    Salary  	INT,
    PRIMARY KEY (ACTOR, Title),
    FOREIGN KEY (ACTOR) REFERENCES Actors ON DELETE CASCADE,
    FOREIGN KEY (Title) REFERENCES Content ON DELETE CASCADE,
);

create VIEW [lessThan500upto1]
AS
SELECT A1.Actor
FROM ActedIn A1
EXCEPT
SELECT A.Actor
FROM ActedIn A
WHERE (A.Salary<=500000)
GROUP BY (A.Actor)
HAVING COUNT(A.Title)>1

create VIEW [lessThan500AllAttributes]
AS
SELECT L.Actor, A.Title, A.Salary
FROM lessThan500upto1 L, ActedIn A
WHERE (L.Actor = A.Actor)

create VIEW [numOfContentsPerActor]
AS
SELECT L.Actor, COUNT(L.Title) AS numOfContents
FROM lessThan500AllAttributes L
GROUP BY (L.Actor)

create VIEW [Q1]
AS
SELECT N.Actor
FROM numOfContentsPerActor N
WHERE (N.numOfContents >= ALL(SELECT N1.numOfContents FROM numOfContentsPerActor N1))

-- Second condition --

CREATE VIEW [countriesToLikers]
AS
SELECT A.FavoriteCountry, COUNT(A.Actor) as numOfActorsLiked
FROM Actors A
GROUP BY (A.FavoriteCountry)

CREATE VIEW [CountryRatio]
AS
SELECT C1.FavoriteCountry AS Country,  CAST(C1.numOfActorsLiked AS FLOAT)/CAST(C2.Area AS FLOAT) AS ratio
FROM countriesToLikers C1, Countries C2
WHERE (C1.FavoriteCountry = C2.Country)

CREATE VIEW [Q2]
AS
SELECT C1.Country
FROM CountryRatio C1
WHERE (C1.ratio>=ALL(SELECT C.ratio FROM CountryRatio C))

-- Third Condition --

CREATE VIEW [Q3]
AS
SELECT COUNT(*) AS NumOfMovies
FROM ActedIn A, Movies M, Content C
WHERE (A.Title = M.Title AND C.Title = M.Title AND YEAR(C.Release_Date)>=2018 AND A.Actor = M.Director)

CREATE VIEW [Reuslt]
AS
SELECT *
FROM Q1,Q2,Q3