
CREATE TABLE `Concepto` (
                `sCveConcepto` SMALLINT AUTO_INCREMENT NOT NULL,
                `sOrden` SMALLINT NOT NULL,
                `sDescripcion` VARCHAR(100) NOT NULL,
                `sTipoUsuario` VARCHAR(30) NOT NULL,
                `sGrupo` VARCHAR(30) NOT NULL,
                PRIMARY KEY (`sCveConcepto`)
);


CREATE TABLE `Sector` (
                `sCveSector` SMALLINT NOT NULL,
                `sLocalidad` VARCHAR(50) NOT NULL,
                `sMunicipio` VARCHAR(30) NOT NULL,
                `sJurisdiccion` VARCHAR(10) NOT NULL,
                `sEstado` VARCHAR(30) NOT NULL,
                `sRegionSanitaria` VARCHAR(300) NOT NULL,
                PRIMARY KEY (`sCveSector`)
);


CREATE TABLE `SectoresEvaluados` (
                `sRFCCoord` SMALLINT NOT NULL,
                `sCveSector` SMALLINT NOT NULL,
                PRIMARY KEY (`sRFCCoord`, `sCveSector`)
);


CREATE TABLE `SupervisionJefeSector` (
                `sRFCCoord` SMALLINT NOT NULL,
                `sCveSector` SMALLINT NOT NULL,
                `sObservaciones` VARCHAR(200) NOT NULL,
                PRIMARY KEY (`sRFCCoord`, `sCveSector`)
);


CREATE TABLE `SupervisionJefeBrigada` (
                `sCveSector` SMALLINT NOT NULL,
                `sObservaciones` VARCHAR(200) NOT NULL,
                PRIMARY KEY (`sCveSector`)
);


CREATE TABLE `Brigada` (
                `CveBrigada` INT AUTO_INCREMENT NOT NULL,
                `sCveSector` SMALLINT NOT NULL,
                `dFecha` DATE NOT NULL,
                `sCiclo` VARCHAR(10) NOT NULL,
                `sSemEpidemio` VARCHAR(10) NOT NULL,
                `sEstrategia` VARCHAR(20) NOT NULL,
                PRIMARY KEY (`CveBrigada`)
);


CREATE TABLE `SupervisionAplicativo` (
                `CveBrigada` INT NOT NULL,
                `sMarcaInsecticida` VARCHAR(30) NOT NULL,
                `sTipoSupervision` VARCHAR(10) NOT NULL,
                `sObservaciones` VARCHAR(200) NOT NULL,
                PRIMARY KEY (`CveBrigada`)
);


CREATE TABLE `Usuario` (
                `sRfc` SMALLINT AUTO_INCREMENT NOT NULL,
                `sApeMaterno` VARCHAR(30) NOT NULL,
                `sApePaterno` VARCHAR(30) NOT NULL,
                `sTipoUsuario` VARCHAR(30) NOT NULL,
                `sEmail` VARCHAR(50) NOT NULL,
                `sPassword` VARCHAR(20) NOT NULL,
                PRIMARY KEY (`sRfc`)
);


CREATE TABLE `EquipoBrigada` (
                `CveBrigada` INT NOT NULL,
                `sRfc` SMALLINT NOT NULL,
                PRIMARY KEY (`CveBrigada`, `sRfc`)
);


CREATE TABLE `CL1` (
                `CveBrigada` INT NOT NULL,
                `sRfc` SMALLINT NOT NULL,
               ` sObservaciones` VARCHAR(200) NOT NULL,
                PRIMARY KEY (`CveBrigada`, `sRfc`)
);


CREATE TABLE `CL1Datos` (
               `CveBrigada` INT NOT NULL,
                `sRfc` SMALLINT NOT NULL,
                `sOrden` SMALLINT NOT NULL,
                `sDomicilio` VARCHAR(100) NOT NULL,
                `sCveManzana` VARCHAR(10) NOT NULL,
                `bLote` BOOLEAN NOT NULL,
                `sCasa` VARCHAR(2) NOT NULL,
                `nRevisados` INT NOT NULL,
                `nAbatizados` INT NOT NULL,
                `nEliminados` INT NOT NULL,
                `nControlados` INT NOT NULL,
                `nNoTratados` INT NOT NULL,
                `nLarvicidaConsumido` DOUBLE NOT NULL,
                `nVolumenTratado` DOUBLE NOT NULL,
                `nHabitantes` INT NOT NULL,
                PRIMARY KEY (`CveBrigada`, `sRfc`, `sOrden`)
);


CREATE TABLE Calificaciones (
                sCveConcepto SMALLINT NOT NULL,
                CveBrigada INT NOT NULL,
                sRfc SMALLINT NOT NULL,
                sCalificacion FLOAT NOT NULL,
                PRIMARY KEY (sCveConcepto, CveBrigada, sRfc)
);


ALTER TABLE Calificaciones ADD CONSTRAINT concepto_calificaciones_fk
FOREIGN KEY (sCveConcepto)
REFERENCES Concepto (sCveConcepto)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE Brigada ADD CONSTRAINT sector_brigada_fk
FOREIGN KEY (sCveSector)
REFERENCES Sector (sCveSector)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE SupervisionJefeBrigada ADD CONSTRAINT sector_supervisionjefebrigada_fk
FOREIGN KEY (sCveSector)
REFERENCES Sector (sCveSector)
ON DELETE RESTRICT
ON UPDATE CASCADE;

ALTER TABLE SectoresEvaluados ADD CONSTRAINT sector_sectoresevaluados_fk
FOREIGN KEY (sCveSector)
REFERENCES Sector (sCveSector)
ON DELETE RESTRICT
ON UPDATE CASCADE;

ALTER TABLE SupervisionJefeSector ADD CONSTRAINT sectoresevaluados_supervisionjefesector_fk
FOREIGN KEY (sRFCCoord, sCveSector)
REFERENCES SectoresEvaluados (sRFCCoord, sCveSector)
ON DELETE RESTRICT
ON UPDATE CASCADE;

ALTER TABLE EquipoBrigada ADD CONSTRAINT brigada_equipobrigada_fk
FOREIGN KEY (CveBrigada)
REFERENCES Brigada (CveBrigada)
ON DELETE RESTRICT
ON UPDATE CASCADE;

ALTER TABLE SupervisionAplicativo ADD CONSTRAINT brigada_supervisionaplicativo_fk
FOREIGN KEY (CveBrigada)
REFERENCES Brigada (CveBrigada)
ON DELETE RESTRICT
ON UPDATE CASCADE;

ALTER TABLE EquipoBrigada ADD CONSTRAINT usuario_equipobrigada_fk
FOREIGN KEY (sRfc)
REFERENCES Usuario (sRfc)
ON DELETE RESTRICT
ON UPDATE CASCADE;

ALTER TABLE Calificaciones ADD CONSTRAINT equipobrigada_calificaciones_fk
FOREIGN KEY (sRfc, CveBrigada)
REFERENCES EquipoBrigada (sRfc, CveBrigada)
ON DELETE RESTRICT
ON UPDATE CASCADE;

ALTER TABLE CL1 ADD CONSTRAINT equipobrigada_cl1_fk
FOREIGN KEY (CveBrigada, sRfc)
REFERENCES EquipoBrigada (CveBrigada, sRfc)
ON DELETE RESTRICT
ON UPDATE CASCADE;

ALTER TABLE CL1Datos ADD CONSTRAINT cl1_cl1datos_fk
FOREIGN KEY (CveBrigada, sRfc)
REFERENCES CL1 (CveBrigada, sRfc)
ON DELETE RESTRICT
ON UPDATE CASCADE;
