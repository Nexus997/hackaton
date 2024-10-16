-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema administracao
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema administracao
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `administracao` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
USE `administracao` ;

-- -----------------------------------------------------
-- Table `administracao`.`departamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `administracao`.`departamento` (
  `idDepartamento` INT NOT NULL AUTO_INCREMENT,
  `nomeDepartamento` VARCHAR(100) NULL DEFAULT NULL,
  `qtdFuncionarios` INT NULL DEFAULT '0',
  `localDepartamento` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`idDepartamento`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `administracao`.`funcionario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `administracao`.`funcionario` (
  `idFuncionario` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NULL DEFAULT NULL,
  `documento` VARCHAR(100) NULL DEFAULT NULL,
  `idade` INT NULL DEFAULT NULL,
  `dataNasc` DATE NULL DEFAULT NULL,
  `dataAdmissao` DATE NULL DEFAULT NULL,
  `idDepartamento` INT NULL DEFAULT NULL,
  `contato` VARCHAR(15) NULL DEFAULT NULL,
  `salario` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`idFuncionario`),
  INDEX `idDepartamento` (`idDepartamento` ASC) VISIBLE,
  CONSTRAINT `funcionario_ibfk_1`
    FOREIGN KEY (`idDepartamento`)
    REFERENCES `administracao`.`departamento` (`idDepartamento`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `administracao`.`faltas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `administracao`.`faltas` (
  `idFalta` INT NOT NULL AUTO_INCREMENT,
  `idFuncionario` INT NULL DEFAULT NULL,
  `dataFalta` DATE NULL DEFAULT NULL,
  `motivo` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`idFalta`),
  INDEX `idFuncionario` (`idFuncionario` ASC) VISIBLE,
  CONSTRAINT `faltas_ibfk_1`
    FOREIGN KEY (`idFuncionario`)
    REFERENCES `administracao`.`funcionario` (`idFuncionario`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `administracao`.`folgas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `administracao`.`folgas` (
  `idFolgas` INT NOT NULL AUTO_INCREMENT,
  `idFuncionario` INT NULL DEFAULT NULL,
  `dataFolgas` DATE NULL DEFAULT NULL,
  `tipo` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`idFolgas`),
  INDEX `idFuncionario` (`idFuncionario` ASC) VISIBLE,
  CONSTRAINT `folgas_ibfk_1`
    FOREIGN KEY (`idFuncionario`)
    REFERENCES `administracao`.`funcionario` (`idFuncionario`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
