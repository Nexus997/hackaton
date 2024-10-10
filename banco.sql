-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema hackatonsaude
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema hackatonsaude
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `hackatonsaude` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
USE `hackatonsaude` ;

-- -----------------------------------------------------
-- Table `hackatonsaude`.`acoes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hackatonsaude`.`acoes` (
  `idAcao` INT NOT NULL AUTO_INCREMENT,
  `nomeAcao` VARCHAR(45) NULL DEFAULT NULL,
  `dataAcao` DATE NULL DEFAULT NULL,
  `tipoAcao` VARCHAR(45) NULL DEFAULT NULL,
  `localAcao` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`idAcao`))
ENGINE = InnoDB
AUTO_INCREMENT = 30
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `hackatonsaude`.`paciente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hackatonsaude`.`paciente` (
  `idPaciente` INT NOT NULL AUTO_INCREMENT,
  `nomePaciente` VARCHAR(115) NULL DEFAULT NULL,
  `dataNasc` DATE NULL DEFAULT NULL,
  `bairro` VARCHAR(90) NULL DEFAULT NULL,
  `generoPaciente` VARCHAR(45) NULL DEFAULT NULL,
  `statusTrabalho` VARCHAR(45) NULL DEFAULT NULL,
  `contatoPaciente` VARCHAR(45) NULL DEFAULT NULL,
  `documentoPaciente` VARCHAR(45) NULL DEFAULT NULL,
  `observacaoPaciente` VARCHAR(1000) NULL DEFAULT NULL,
  `alturaPaciente` VARCHAR(45) NULL DEFAULT NULL,
  `pesoPaciente` VARCHAR(45) NULL DEFAULT NULL,
  `tipoSanguineo` VARCHAR(2) NULL DEFAULT NULL,
  `pressao` VARCHAR(8) NULL DEFAULT NULL,
  `dataAtendimento` DATE NULL DEFAULT NULL,
  `localAtendimento` VARCHAR(60) NULL DEFAULT NULL,
  `responsavelAtendimento` VARCHAR(60) NULL DEFAULT NULL,
  `observacaoAtendente` VARCHAR(1000) NULL DEFAULT NULL,
  `idade` INT NULL DEFAULT NULL,
  `idAcao` INT NULL DEFAULT NULL,
  PRIMARY KEY (`idPaciente`))
ENGINE = InnoDB
AUTO_INCREMENT = 48
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `hackatonsaude`.`paciente_acoes`
-- -----------------------------------------------------

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
