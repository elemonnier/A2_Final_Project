------------------------------------------------------------
--        Script Postgre
------------------------------------------------------------



------------------------------------------------------------
-- Table: Aeroport
------------------------------------------------------------
CREATE TABLE public.Aeroport(
	NomAeroport    VARCHAR (50) NOT NULL ,
	NomVille       VARCHAR (50) NOT NULL ,
	latitude       FLOAT  NOT NULL ,
	longitude      FLOAT  NOT NULL ,
	Etat           VARCHAR (50) NOT NULL ,
	Surcharge      FLOAT  NOT NULL  ,
	CONSTRAINT Aeroport_PK PRIMARY KEY (NomAeroport)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: Vol
------------------------------------------------------------
CREATE TABLE public.Vol(
	IDVol                  VARCHAR (10) NOT NULL ,
	Distance               INT  NOT NULL ,
	HeureArrive            TIMETZ  NOT NULL ,
	HeureDepart            TIMETZ  NOT NULL ,
	FlighSize              INT  NOT NULL ,
	DayOfWeek              INT  NOT NULL ,
	NomAeroport            VARCHAR (50) NOT NULL ,
	NomAeroport__Atterit   VARCHAR (50) NOT NULL  ,
	CONSTRAINT Vol_PK PRIMARY KEY (IDVol)

	,CONSTRAINT Vol_Aeroport_FK FOREIGN KEY (NomAeroport) REFERENCES public.Aeroport(NomAeroport)
	,CONSTRAINT Vol_Aeroport0_FK FOREIGN KEY (NomAeroport__Atterit) REFERENCES public.Aeroport(NomAeroport)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: DateVol
------------------------------------------------------------
CREATE TABLE public.DateVol(
	idDateVol    SERIAL NOT NULL ,
	NbPassager   INT  NOT NULL ,
	DateDepart   INT  NOT NULL ,
	IDVol        VARCHAR (10) NOT NULL  ,
	CONSTRAINT DateVol_PK PRIMARY KEY (idDateVol)

	,CONSTRAINT DateVol_Vol_FK FOREIGN KEY (IDVol) REFERENCES public.Vol(IDVol)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: Passagers
------------------------------------------------------------
CREATE TABLE public.Passagers(
	IDPassager        VARCHAR (10) NOT NULL ,
	Nom               VARCHAR (50) NOT NULL ,
	Prenom            VARCHAR (50) NOT NULL ,
	AddresseMail      VARCHAR (50) NOT NULL ,
	DateDeNaissance   DATE  NOT NULL ,
	idDateVol         INT  NOT NULL  ,
	CONSTRAINT Passagers_PK PRIMARY KEY (IDPassager)

	,CONSTRAINT Passagers_DateVol_FK FOREIGN KEY (idDateVol) REFERENCES public.DateVol(idDateVol)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: Tarif
------------------------------------------------------------
CREATE TABLE public.Tarif(
	idTarif       SERIAL NOT NULL ,
	Tarifs        FLOAT  NOT NULL ,
	weFlights     INT  NOT NULL ,
	FareCode      VARCHAR (1) NOT NULL ,
	DateDepart    INT  NOT NULL ,
	fillingRate   INT  NOT NULL ,
	Route         VARCHAR (50) NOT NULL ,
	idDateVol     INT  NOT NULL  ,
	CONSTRAINT Tarif_PK PRIMARY KEY (idTarif)

	,CONSTRAINT Tarif_DateVol_FK FOREIGN KEY (idDateVol) REFERENCES public.DateVol(idDateVol)
)WITHOUT OIDS;

