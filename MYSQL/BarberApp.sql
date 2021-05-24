-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Mag 24, 2021 alle 17:51
-- Versione del server: 10.4.18-MariaDB
-- Versione PHP: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `BarberApp`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `appuntamento`
--

CREATE TABLE `appuntamento` (
  `dataInizio` datetime NOT NULL DEFAULT current_timestamp(),
  `cliente` varchar(255) NOT NULL,
  `salone` varchar(255) NOT NULL,
  `servizio` int(11) NOT NULL,
  `fine` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `appuntamento`
--

INSERT INTO `appuntamento` (`dataInizio`, `cliente`, `salone`, `servizio`, `fine`) VALUES
('2021-05-25 19:50:00', 'bscmtt', '1234567890', 32, '2021-05-25 20:00:00'),
('2021-05-28 17:30:00', 'bscmtt', '1234567890', 30, '2021-05-28 18:00:00');

--
-- Trigger `appuntamento`
--
DELIMITER $$
CREATE TRIGGER `durataAppuntamento` BEFORE INSERT ON `appuntamento` FOR EACH ROW SET NEW.fine =
	DATE_ADD(NEW.dataInizio, INTERVAL (SELECT Durata FROM servizi s WHERE s.Id=NEW.servizio AND s.idSalone = NEW.salone) MINUTE)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `numAppuntamenti` AFTER INSERT ON `appuntamento` FOR EACH ROW UPDATE cliente c
    SET c.NumPrenotazioni = c.NumPrenotazioni+1
    WHERE c.CF = NEW.cliente
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `categorie`
--

INSERT INTO `categorie` (`id`, `nome`) VALUES
(1, 'capelli'),
(2, 'barba');

-- --------------------------------------------------------

--
-- Struttura della tabella `cliente`
--

CREATE TABLE `cliente` (
  `CF` varchar(255) NOT NULL,
  `Nome` varchar(255) NOT NULL,
  `Cognome` varchar(255) NOT NULL,
  `Mail` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `NumPrenotazioni` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `cliente`
--

INSERT INTO `cliente` (`CF`, `Nome`, `Cognome`, `Mail`, `Password`, `NumPrenotazioni`) VALUES
('bscbrn', 'Bruno', 'Busacca', 'brunobusacca@gmail.com', '$2y$10$1qBLVROHBZWqHSiwIoZeM.gGOsBmMJrdpOeI3ggdSxEBvhXJ8ef.i', '0'),
('bscmtt', 'Matteo', 'Busacca', 'matteobusacca@gmail.com', '$2y$10$CYqzTDFnWIftkl55abfzz.dbHt2gSuO0wvh7lddOJW9K6eA5kfumC', '2');

--
-- Trigger `cliente`
--
DELIMITER $$
CREATE TRIGGER `numPr0` BEFORE INSERT ON `cliente` FOR EACH ROW SET NEW.NumPrenotazioni = 0
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `Commissioni`
--

CREATE TABLE `Commissioni` (
  `salone` varchar(255) NOT NULL,
  `dataInizio` date NOT NULL DEFAULT current_timestamp(),
  `scadenza` date NOT NULL,
  `costo` float NOT NULL DEFAULT 50,
  `costoScontato` float NOT NULL,
  `pagato` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `Commissioni`
--

INSERT INTO `Commissioni` (`salone`, `dataInizio`, `scadenza`, `costo`, `costoScontato`, `pagato`) VALUES
('1234567890', '2021-05-24', '2021-06-23', 50, 50, 0),
('1423568790', '2021-05-24', '2021-06-23', 50, 50, 0);

--
-- Trigger `Commissioni`
--
DELIMITER $$
CREATE TRIGGER `calcScadenza` BEFORE INSERT ON `Commissioni` FOR EACH ROW SET NEW.scadenza = DATE_ADD(NEW.dataInizio, INTERVAL 30 DAY)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `calcSconto` BEFORE INSERT ON `Commissioni` FOR EACH ROW BEGIN
        DECLARE num INT;
        SET num = (SELECT COUNT(*) FROM commissioni WHERE Salone=NEW.Salone);
         
          SET NEW.CostoScontato = 
          CASE
                    WHEN num > 10 THEN NEW.Costo - NEW.Costo * (10/100)
                    WHEN num > 0 OR num = 0 THEN NEW.Costo - NEW.Costo * (num/100)
          END;
                
	END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `salone`
--

CREATE TABLE `salone` (
  `Iva` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `citta` varchar(255) NOT NULL,
  `indirizzo` varchar(255) NOT NULL,
  `sesso` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `img` varchar(255) DEFAULT 'default.jpeg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `salone`
--

INSERT INTO `salone` (`Iva`, `nome`, `citta`, `indirizzo`, `sesso`, `mail`, `password`, `img`) VALUES
('1234567890', 'Barber\'s Brother', 'Grammichele', 'Via Vittorio Alfieri 85', 'uomo', 'barberbrother@gmail.com', '$2y$10$AhXaChDXBpEpY6ygFef1Y.oeJ33Ewn6g6eXd2lEbWL4uf39S5.Uya', 'barbers_brother.jpeg'),
('1423568790', 'CiccioBarber', 'Catania', 'Via Vittorio Veneto 145', 'Uomo/Donna', 'cicciobarber@gmail.com', '$2y$10$KFQTrEXjaAkRpvvW9YcBMO7ah6oiDgxN1FoEjwuZnVl2R1K8r7Wim', 'cicciobarber.jpg');

--
-- Trigger `salone`
--
DELIMITER $$
CREATE TRIGGER `addSaloneToCommissioni` AFTER INSERT ON `salone` FOR EACH ROW INSERT INTO commissioni (Salone) VALUES (NEW.Iva)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `saloni_preferiti`
--

CREATE TABLE `saloni_preferiti` (
  `idCliente` varchar(255) NOT NULL,
  `idSalone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `saloni_preferiti`
--

INSERT INTO `saloni_preferiti` (`idCliente`, `idSalone`) VALUES
('bscmtt', '1234567890');

-- --------------------------------------------------------

--
-- Struttura della tabella `servizi`
--

CREATE TABLE `servizi` (
  `id` int(11) NOT NULL,
  `idSalone` varchar(255) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `durata` int(11) NOT NULL,
  `prezzo` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `servizi`
--

INSERT INTO `servizi` (`id`, `idSalone`, `id_categoria`, `nome`, `durata`, `prezzo`) VALUES
(25, '1423568790', 1, 'Taglio Maschile completo', 30, 14),
(26, '1423568790', 1, 'Taglio Maschile Lati', 10, 5),
(27, '1423568790', 2, 'Barba Completa', 10, 10),
(28, '1423568790', 2, 'Barba Completa + Massaggio', 20, 20),
(29, '1423568790', 1, 'Taglio Maschile + colore', 60, 25),
(30, '1234567890', 1, 'Taglio Maschile completo', 30, 14),
(31, '1234567890', 1, 'Taglio Maschile Lati', 10, 5),
(32, '1234567890', 2, 'Barba Completa', 10, 10),
(33, '1234567890', 2, 'Barba Completa + Massaggio', 20, 20),
(34, '1234567890', 1, 'Taglio Maschile + colore', 60, 25);

--
-- Trigger `servizi`
--
DELIMITER $$
CREATE TRIGGER `noNomeDuplicato` BEFORE INSERT ON `servizi` FOR EACH ROW BEGIN
    	IF EXISTS (SELECT * FROM servizi s WHERE s.Nome=NEW.Nome AND s.IdSalone=NEW.IdSalone) THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Esiste già un servizio con questo nome'; 
        END IF;
    END
$$
DELIMITER ;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `appuntamento`
--
ALTER TABLE `appuntamento`
  ADD PRIMARY KEY (`dataInizio`,`cliente`,`salone`,`servizio`),
  ADD KEY `saloon` (`salone`),
  ADD KEY `servizi` (`servizio`),
  ADD KEY `cliente` (`cliente`);

--
-- Indici per le tabelle `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`CF`);

--
-- Indici per le tabelle `Commissioni`
--
ALTER TABLE `Commissioni`
  ADD PRIMARY KEY (`salone`,`dataInizio`);

--
-- Indici per le tabelle `salone`
--
ALTER TABLE `salone`
  ADD PRIMARY KEY (`Iva`);

--
-- Indici per le tabelle `saloni_preferiti`
--
ALTER TABLE `saloni_preferiti`
  ADD PRIMARY KEY (`idCliente`,`idSalone`),
  ADD KEY `salonePreferito_salone` (`idSalone`);

--
-- Indici per le tabelle `servizi`
--
ALTER TABLE `servizi`
  ADD PRIMARY KEY (`id`,`idSalone`),
  ADD KEY `id_salone` (`idSalone`),
  ADD KEY `cat` (`id_categoria`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `servizi`
--
ALTER TABLE `servizi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `appuntamento`
--
ALTER TABLE `appuntamento`
  ADD CONSTRAINT `cliente` FOREIGN KEY (`cliente`) REFERENCES `cliente` (`CF`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `saloon` FOREIGN KEY (`salone`) REFERENCES `salone` (`Iva`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `servizi` FOREIGN KEY (`servizio`) REFERENCES `servizi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `Commissioni`
--
ALTER TABLE `Commissioni`
  ADD CONSTRAINT `salone_commissioni` FOREIGN KEY (`salone`) REFERENCES `salone` (`Iva`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `saloni_preferiti`
--
ALTER TABLE `saloni_preferiti`
  ADD CONSTRAINT `salonePreferito_cliente` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`CF`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salonePreferito_salone` FOREIGN KEY (`idSalone`) REFERENCES `salone` (`Iva`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `servizi`
--
ALTER TABLE `servizi`
  ADD CONSTRAINT `cat` FOREIGN KEY (`id_categoria`) REFERENCES `categorie` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `salone` FOREIGN KEY (`idSalone`) REFERENCES `salone` (`Iva`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
