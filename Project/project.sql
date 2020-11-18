DROP TABLE Pokemon;
DROP TABLE Species;
DROP TABLE Type;
DROP TABLE Stats;
DROP TABLE Item;
DROP TABLE Evo_Item;
DROP TABLE Status_Item;
DROP TABLE Mega_Evolution;
DROP TABLE has;
DROP TABLE ofType;
DROP TABLE is_of;
DROP TABLE WeakAgainst;
DROP TABLE requires;
DROP TABLE uses;
DROP TABLE has_a;
DROP TABLE EvolvesInto;

-- Pokemon table
CREATE TABLE Pokemon (
	Nickname			VARCHAR(255),
	Gender			BOOL,
	TimeCaught		DATETIME,
	ID					INT,
	PRIMARY KEY (ID, TimeCaught),
	FOREIGN KEY (ID) REFERENCES Species ON DELETE/UPDATE CASCADE
);

-- Species table
CREATE TABLE Species (
	ID						INT,
	SpName					VARCHAR(255),
	Ability2 			VARCHAR(255),
	Ability1				VARCHAR(255),
	HiddenAbility	VARCHAR(255),
	UNIQUE (SpName),
	PRIMARY KEY (ID),
	FOREIGN KEY (ID) REFERENCES EvolvesInto ON UPDATE CASCADE
);

-- Type table
CREATE TABLE Type (
	TypeName			VARCHAR(20),
	PRIMARY KEY (TypeName)
);

-- Stats table
CREATE TABLE Stats (
	HP					INT,
	Atk				INT,
	Spatk			INT,
	Def				INT,
	Spdef			INT,
	Speed			INT,
	PRIMARY KEY (ID),
	FOREIGN KEY (ID) REFERENCES Species ON DELETE CASCADE
);

-- Item table
CREATE TABLE Item (
	ItemName			VARCHAR(20),
	Quantity			INT,
	PRIMARY KEY (ItemName)
);

-- Evo Item table
CREATE TABLE Evo_Item (
	ItemName		VARCHAR(20),
	Usage			VARCHAR(20),
	FOREIGN KEY (ItemName) REFERENCES Item
);

-- Status Item table
CREATE TABLE Status_Item (
	ItemName			VARCHAR(20),
	Status			VARCHAR(20),
	FOREIGN KEY (ItemName) REFERENCES Item
);

-- Mega_Evolution table
CREATE TABLE Mega_Evolution (
	MeName			VARCHAR(20),
	SpName			VARCHAR(20),
	Mega_Stone			VARCHAR(20),
	PRIMARY KEY (MeName),
	FOREIGN KEY (SpName) REFERENCES Species ON DELETE CASCADE,
	FOREIGN KEY (Mega Stone) REFERENCES requires ON DELETE CASCADE
);

-- has table
CREATE TABLE has (
	ID				VARCHAR(20),
	PRIMARY KEY (ID),
	FOREIGN KEY (ID) REFERENCES Species
);

-- is of table
CREATE TABLE is_of (
	TimeCaught			DATETIME,
	ID						VARCHAR(20),
	PRIMARY KEY (TimeCaught, ID),
	FOREIGN KEY (TimeCaught) REFERENCES Pokemon,
	FOREIGN KEY (ID) REFERENCES Species
);

-- ofType table
CREATE TABLE ofType (
	ID			VARCHAR(20),
	Type1		VARCHAR(20),
	Type2 		VARCHAR(20),
	PRIMARY KEY (ID, TypeName),
	FOREIGN KEY (ID) REFERENCES Species,
	FOREIGN KEY (TypeName) REFERENCES Type
);

-- WeakAgainst table
CREATE TABLE WeakAgainst (
	Type1_TypeName		VARCHAR(20),
	Type2_TypeName		VARCHAR(20),
	PRIMARY KEY (Type1_TypeName, Type2_TypeName),
	FOREIGN KEY (Type1_TypeName) REFERENCES Type(TypeName),
	FOREIGN KEY (Type2_TypeName) REFERENCES Type(TypeName)
);

-- requires table
CREATE TABLE requires (
	Mega_Stone		VARCHAR(20),
	MeName				VARCHAR(20),
	PRIMARY KEY (Mega_Stone, MeName),
	FOREIGN KEY (MeName) REFERENCES Mega_Evolution
);

-- uses table
CREATE TABLE uses (
	TimeCaught		DATETIME,
	ItemName			VARCHAR(20),
	PRIMARY KEY (TimeCaught, ItemName),
	FOREIGN KEY (TimeCaught) REFERENCES Pokemon
);

-- has_a table
CREATE TABLE has_a (
	MeName			VARCHAR(20),
	ID					INT,
	PRIMARY KEY (ID),
	FOREIGN KEY (MeName) REFERENCES Mega_Evolution,
	FOREIGN KEY (ID) REFERENCES Species
);

-- EvolvesInto table
CREATE TABLE EvolvesInto (
	SpID1			INT,
	SpID2			INT,
	PRIMARY KEY (SpID1, SpID2),
	FOREIGN KEY (SpID1) REFERENCES Species(ID),
	FOREIGN KEY (SpID2) REFERENCES Species(ID)
);



-- insert into species table
INSERT INTO Species VALUES (
    (1,'Bulbasaur','Overgrow',NULL,'Chrolophyll'),
    (2,'Ivysaur','Overgrow',NULL,'Chrolophyll'),
    (3,'Venusaur','Overgrow',NULL,'Chrolophyll'),
    (3,'Mega Venusaur','Thick Fat',NULL,NULL),
    (4,'Charmander','Blaze',NULL,'Solar Power'),
    (5,'Charmeleon','Blaze',NULL,'Solar Power'),
    (6,'Charizard','Blaze',NULL,'Solar Power'),
    (6,'Mega Charizard X','Tough Claws',NULL,NULL),
    (6,'Mega Charizard Y','Drought',NULL,NULL),
    (7,'Squirtle','Torrent',NULL,'Rain Dish'),
    (8,'Wartortle','Torrent',NULL,'Rain Dish'),
    (9,'Blastoise','Torrent',NULL,'Rain Dish'),
    (9,'Mega Blastoise','Mega Launcher',NULL,NULL),
    (10,'Caterpie','Shield Dust',NULL,'Run Away'),
    (11,'Metapod','Shed Skin',NULL,NULL),
    (12,'Butterfree','Compound Eyes',NULL,'Tinted Lens'),
    (13,'Weedle','Shield Dust',NULL,'Run Away'),
    (14,'Kakuna','Shed Skin',NULL,NULL),
    (15,'Beedrill','Swarm',NULL,'Sniper'),
    (15,'Mega Beedrill','Adaptability',NULL,NULL),
    (16,'Pidgey','Keen Eye','Tangled Feet','Big Pecks'),
    (17,'Pidgeotto','Keen Eye','Tangled Feet','Big Pecks'),
    (18,'Pidgeot','Keen Eye','Tangled Feet','Big Pecks'),
    (18,'Mega Pidgeot','No Guard',NULL,NULL),
    (19,'Rattata','Run Away','Guts','Hustle'),
    (19,'Rattata','Gluttony','Hustle','Thick Fat'),
    (20,'Raticate','Run Away','Guts','Hustle'),
    (20,'Raticate','Gluttony','Hustle','Thick Fat'),
    (21,'Spearow','Keen Eye',NULL,'Sniper'),
    (22,'Fearow','Keen Eye',NULL,'Sniper'),
    (23,'Ekans','Intimidate','Shed Skin','Unnerve'),
    (24,'Arbok','Intimidate','Shed Skin','Unnerve'),
    (25,'Pikachu','Static',NULL,'Lightning Rod'),
    (26,'Raichu','Static',NULL,'Lightning Rod'),
    (26,'Raichu','Surge Surfer',NULL,NULL),
    (27,'Sandshrew','Sand Veil',NULL,'Sand Rush'),
    (27,'Sandshrew','Snow Cloak',NULL,'Slush Rush'),
    (28,'Sandslash','Sand Veil',NULL,'Sand Rush'),
    (28,'Sandslash','Snow Cloak',NULL,'Slush Rush'),
    (29,'Nidoran F','Poison Point','Rivalry','Hustle'),
    (30,'Nidorina','Poison Point','Rivalry','Hustle'),
    (31,'Nidoqueen','Poison Point','Rivalry','Sheer Force'),
    (32,'Nidoran M','Poison Point','Rivalry','Hustle'),
    (33,'Nidorino','Poison Point','Rivalry','Hustle'),
    (34,'Nidoking','Poison Point','Rivalry','Sheer Force'),
    (35,'Clefairy','Cute Charm','Magic Guard','Friend Guard'),
    (36,'Clefable','Cute Charm','Magic Guard','Friend Guard'),
    (37,'Vulpix','Flash Fire',NULL,'Drought'),
    (37,'Vulpix','Snow Cloak',NULL,'Snow Warning'),
    (38,'Ninetales','Flash Fire',NULL,'Drought'),
    (38,'Ninetales','Snow Cloak',NULL,'Snow Warning'),
    (39,'Jigglypuff','Cute Charm','Competitive','Friend Guard'),
    (40,'Wigglytuff','Cute Charm','Competitive','Friend Guard'),
    (41,'Zubat','Inner Focus',NULL,'Infiltrator'),
    (42,'Golbat','Inner Focus',NULL,'Infiltrator'),
    (43,'Oddish','Chlorophyll',NULL,'Run Away'),
    (44,'Gloom','Chlorophyll',NULL,'Stench'),
    (45,'Vileplume','Chlorophyll',NULL,'Effect Spore'),
    (46,'Paras','Effect Spore','Dry Skin','Damp'),
    (47,'Parasect','Effect Spore','Dry Skin','Damp'),
    (48,'Venonat','Compound Eyes','Tinted Lens','Run Away'),
    (49,'Venomoth','Shield Dust','Tinted Lens','Wonder Skin'),
    (50,'Diglett','Sand Veil','Arena Trap','Sand Force'),
    (50,'Diglett','Sand Veil','Tangling Hair','Sand Force'),
    (51,'Dugtrio','Sand Veil','Arena Trap','Sand Force'),
    (51,'Dugtrio','Sand Veil','Tangling Hair','Sand Force'),
    (52,'Meowth','Pickup','Technician','Unnerve'),
    (52,'Meowth','Pickup','Technician','Rattled'),
    (52,'Meowth','Pickup','Tough Claws','Unnerve'),
    (53,'Persian','Limber','Technician','Unnerve'),
    (53,'Persian','Fur Coat','Technician','Rattled'),
    (54,'Psyduck','Damp','Cloud Nine','Swift Swim'),
    (55,'Golduck','Damp','Cloud Nine','Swift Swim'),
    (56,'Mankey','Vital Spilit','Anger Point','Defiant'),
    (57,'Primeape','Vital Spilit','Anger Point','Defiant'),
    (58,'Growlithe','Intimidate','Flash Fire','Justified'),
    (59,'Arcanine','Intimidate','Flash Fire','Justified'),
    (60,'Poliwag','Water Absorb','Damp','Swift Swim'),
    (61,'Poliwhirl','Water Absorb','Damp','Swift Swim'),
    (62,'Poliwrath','Water Absorb','Damp','Swift Swim'),
    (63,'Abra','Synchronize','Inner Focus','Magic guard'),
    (64,'Kadabra','Synchronize','Inner Focus','Magic guard'),
    (65,'Alakazam','Synchronize','Inner Focus','Magic guard'),
    (65,'Mega Alakazam','Trace',NULL,NULL));


-- insert into TypeName
INSERT INTO Type VALUES
		('Normal'),
		('Fire'),
		('Water'),
		('Grass'),
		('Electric'),
		('Ice'),
		('Fighting'),
		('Poison'),
		('Ground'),
		('Flying'),
		('Psychic'),
		('Bug'),
		('Rock'),
		('Ghost'),
		('Dark'),
		('Dragon'),
		('Steel'),
		('Fairy');


-- insert into stats table
INSERT INTO Stats VALUES
    (1,45,49,49,65,65,45),
    (2,60,62,63,80,80,60),
    (3,80,82,83,100,100,80),
    (3,80,100,123,122,120,80),
    (4,39,52,43,60,50,65),
    (5,58,64,58,80,65,80),
    (6,78,84,78,109,85,100),
    (6,78,130,111,130,85,100),
    (6,78,104,78,159,115,100),
    (7,44,48,65,50,64,43),
    (8,59,63,80,65,80,58),
    (9,79,83,100,85,105,78),
    (9,79,103,120,135,115,78),
    (10,45,30,35,20,20,45),
    (11,50,20,55,25,25,30),
    (12,60,45,50,90,80,70),
    (13,40,35,30,20,20,50),
    (14,45,25,50,25,25,35),
    (15,65,90,40,45,80,75),
    (15,65,150,40,15,80,145),
    (16,40,45,40,35,35,56),
    (17,63,60,55,50,50,71),
    (18,83,80,75,70,70,101),
    (18,83,80,80,135,80,121),
    (19,30,56,35,25,35,72),
    (19,30,56,35,25,35,72),
    (20,55,81,60,50,70,97),
    (20,75,71,70,40,80,77),
    (21,40,60,30,31,31,70),
    (22,65,90,65,61,61,100),
    (23,35,60,44,40,54,55),
    (24,60,95,69,65,79,80),
    (25,35,55,40,50,50,90),
    (26,60,90,55,90,80,110),
    (26,60,85,50,95,85,110),
    (27,50,75,85,20,30,40),
    (27,50,75,90,10,35,40),
    (28,75,100,110,45,55,65),
    (28,75,100,120,25,65,65),
    (29,55,47,52,40,40,41),
    (30,70,62,67,55,55,56),
    (31,90,92,87,75,85,76),
    (32,46,57,40,40,40,50),
    (33,61,72,57,55,55,65),
    (34,81,102,77,85,75,85),
    (35,70,45,48,60,65,35),
    (36,95,70,73,95,90,60),
    (37,38,41,40,50,65,65),
    (37,38,41,40,50,65,65),
    (38,73,76,75,81,100,100),
    (38,73,67,75,81,100,109),
    (39,115,45,20,45,25,20),
    (40,140,70,45,85,50,45),
    (41,40,45,35,30,40,55),
    (42,75,80,70,65,75,90),
    (43,45,50,55,75,65,30),
    (44,60,65,70,85,75,40),
    (45,75,80,85,110,90,50),
    (46,35,70,55,45,55,25),
    (47,60,95,80,60,80,30),
    (48,60,55,50,40,55,45),
    (49,70,65,60,90,75,90),
    (50,10,55,25,35,45,95),
    (50,10,55,30,35,45,90),
    (51,35,100,50,50,70,120),
    (51,35,100,60,50,70,110),
    (52,40,45,35,40,40,90),
    (52,40,35,35,50,40,90),
    (52,50,65,55,40,40,40),
    (53,65,70,60,65,65,115),
    (53,65,60,60,75,65,115),
    (54,50,52,48,65,50,55),
    (55,80,82,78,95,80,85),
    (56,40,80,35,35,45,70),
    (57,65,105,60,60,70,95),
    (58,55,70,45,70,50,60),
    (59,90,110,80,100,80,95),
    (60,40,50,40,40,40,90),
    (61,65,65,65,50,50,90),
    (62,90,95,95,70,90,70),
    (63,25,20,15,105,55,90),
    (64,40,35,30,120,70,105),
    (65,55,50,45,135,95,120);


-- insert into ofType
INSERT INTO ofType VALUES
    (1,'Grass','Poison'),
    (2,'Grass','Poison'),
    (3,'Grass','Poison'),
    (3,'Grass','Poison'),
    (4,'Fire',NULL),
    (5,'Fire',NULL),
    (6,'Fire','Flying'),
    (6,'Fire','Dragon'),
    (6,'Fire','Flying'),
    (7,'Water',NULL),
    (8,'Water',NULL),
    (9,'Water',NULL),
    (9,'Water',NULL),
    (10,'Bug',NULL),
    (11,'Bug',NULL),
    (12,'Bug','Flying'),
    (13,'Bug','Poison'),
    (14,'Bug','Poison'),
    (15,'Bug','Poison'),
    (15,'Bug','Poison'),
    (16,'Normal','Flying'),
    (17,'Normal','Flying'),
    (18,'Normal','Flying'),
    (18,'Normal','Flying'),
    (19,'Normal',NULL),
    (19,'Dark','Normal'),
    (20,'Normal',NULL),
    (20,'Dark','Normal'),
    (21,'Normal','Flying'),
    (22,'Normal','Flying'),
    (23,'Poison',NULL),
    (24,'Poison',NULL),
    (25,'Electric',NULL),
    (26,'Electric',NULL),
    (26,'Electric','Psychic'),
    (27,'Ground',NULL),
    (27,'Ice','Steel'),
    (28,'Ground',NULL),
    (28,'Ice','Steel'),
    (29,'Poison',NULL),
    (30,'Poison',NULL),
    (31,'Poison','Ground'),
    (32,'Poison',NULL),
    (33,'Poison',NULL),
    (34,'Poison','Ground'),
    (35,'Fairy',NULL),
    (36,'Fairy',NULL),
    (37,'Fire',NULL),
    (37,'Ice',NULL),
    (38,'Fire',NULL),
    (38,'Ice','Fairy'),
    (39,'Normal','Fairy'),
    (40,'Normal','Fairy'),
    (41,'Poison','Flying'),
    (42,'Poison','Flying'),
    (43,'Grass','Poison'),
    (44,'Grass','Poison'),
    (45,'Grass','Poison'),
    (46,'Bug','Grass'),
    (47,'Bug','Grass'),
    (48,'Bug','Poison'),
    (49,'Bug','Poison'),
    (50,'Ground',NULL),
    (50,'Ground','Steel'),
    (51,'Ground',NULL),
    (51,'Ground','Steel'),
    (52,'Normal',NULL),
    (52,'Dark',NULL),
    (52,'Steel',NULL),
    (53,'Normal',NULL),
    (53,'Dark',NULL),
    (54,'Water',NULL),
    (55,'Water',NULL),
    (56,'Fighting',NULL),
    (57,'Fighting',NULL),
    (58,'Fire',NULL),
    (59,'Fire',NULL),
    (60,'Water',NULL),
    (61,'Water',NULL),
    (62,'Water','Fighting'),
    (63,'Psychic',NULL),
    (64,'Psychic',NULL),
    (65,'Psychic',NULL),
    (65,'Psychic',NULL);

INSERT INTO WeakAgainst VALUES
		('Normal', 'Rock'),
		('Normal', 'Ghost'),
		('Normal', 'Steel'),
		('Normal', 'Fighting'),
		('Fighting', 'Flying'),
		('Fighting', 'Poison'),
		('Fighting', 'Psychic'),
		('Fighting', 'Bug'),
		('Fighting', 'Ghost'),
		('Fighting', 'Fairy'),
		('Flying', 'Rock'),
		('Flying', 'Steel'),
		('Flying', 'Electric'),
		('Flying', 'Ice'),
		('Poison', 'Poison'),
		('Poison', 'Ground'),
		('Poison', 'Rock'),
		('Poison', 'Ghost'),
		('Poison', 'Steel'),
		('Poison', 'Psychic'),
		('Ground', 'Flying'),
		('Ground', 'Bug'),
		('Ground', 'Grass'),
		('Ground', 'Water'),
		('Ground', 'Ice'),
		('Rock', 'Fighting'),
		('Rock', 'Ground'),
		('Rock', 'Steel'),
		('Rock', 'Water'),
		('Rock', 'Grass'),
		('Bug', 'Fighting'),
		('Bug', 'Flying'),
		('Bug', 'Poison'),
		('Bug', 'Ghost'),
		('Bug', 'Steel'),
		('Bug', 'Fire'),
		('Bug', 'Fairy'),
		('Bug', 'Rock'),
		('Ghost', 'Normal'),
		('Ghost', 'Dark'),
		('Ghost', 'Ghost'),
		('Steel', 'Steel'),
		('Steel', 'Fire'),
		('Steel', 'Water'),
		('Steel', 'Electric'),
		('Steel', 'Fighting'),
		('Steel', 'Ground'),
		('Fire', 'Rock'),
		('Fire', 'Fire'),
		('Fire', 'Water'),
		('Fire', 'Dragon'),
		('Fire', 'Ground'),
		('Water', 'Water'),
		('Water', 'Grass'),
		('Water', 'Dragon'),
		('Water', 'Electric'),
		('Grass', 'Flying'),
		('Grass', 'Poison'),
		('Grass', 'Bug'),
		('Grass', 'Steel'),
		('Grass', 'Fire'),
		('Grass', 'Grass'),
		('Grass', 'Dragon'),
		('Grass', 'Ice'),
		('Electric', 'Ground'),
		('Electric', 'Grass'),
		('Electric', 'Electric'),
		('Electric', 'Dragon'),
		('Psychic', 'Steel'),
		('Psychic', 'Psychic'),
		('Psychic', 'Dark'),
		('Psychic', 'Bug'),
		('Psychic', 'Ghost'),
		('Ice', 'Steel'),
		('Ice', 'Fire'),
		('Ice', 'Water'),
		('Ice', 'Ice'),
		('Ice', 'Fighting'),
		('Ice', 'Rock'),
		('Dragon', 'Steel'),
		('Dragon', 'Fairy'),
		('Dragon', 'Dragon'),
		('Dragon', 'Fairy'),
		('Dragon', 'Ice'),
		('Fairy', 'Poison'),
		('Fairy', 'Steel'),
		('Fairy', 'Fire'),
		('Dark', 'Fighting'),
		('Dark', 'Dark'),
		('Dark', 'Fairy'),
		('Dark', 'Bug');

INSERT INTO EvolvesInto VALUES
    (1,2,'Bulbasaur'),
    (2,3,'Ivysaur'),
    (4,5,'Charmander'),
    (5,6,'Charmeleon'),
    (7,8,'Squirtle'),
    (8,9,'Wartortle'),
    (10,11,'Caterpie'),
    (11,12,'Metapod'),
    (13,14,'Kakuna'),
    (14,15,'Beedrill'),
    (15,15,'Mega Beedrill'),
    (16,17,'Pidgeotto'),
    (17,18,'Pidgeot'),
    (18,18,'Mega Pidgeot'),
    (19,19,'Rattata'),
    (19,20,'Raticate'),
    (20,20,'Raticate'),
    (21,22,'Fearow'),
    (23,24,'Arbok'),
    (25,26,'Raichu'),
    (26,26,'Raichu'),
    (27,27,'Sandshrew'),
    (27,28,'Sandslash'),
    (28,28,'Sandslash'),
    (29,30,'Nidorina'),
    (30,31,'Nidoqueen'),
    (32,33,'Nidorino'),
    (33,34,'Nidoking'),
    (35,36,'Clefable'),
    (37,38,'Ninetales'),
    (39,40,'Wigglytuff'),
    (41,42,'Golbat'),
    (43,44,'Gloom'),
    (44,45,'Vileplume'),
    (46,47,'Parasect'),
    (47,48,'Venonat'),
    (48,49,'Venomoth'),
    (50,50,'Diglett'),
    (50,51,'Dugtrio'),
    (51,51,'Dugtrio'),
    (52,53,'Persian'),
    (54,55,'Golduck'),
    (56,57,'Primeape'),
    (58,59,'Arcanine'),
    (60,61,'Poliwhirl'),
    (61,62,'Poliwrath'),
    (63,64,'Kadabra'),
    (64,65,'Alakazam'),
