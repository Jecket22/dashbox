SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(15) NOT NULL,
  `password` binary(60) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Ignored if VerifyLevel config is set to 0',
  `disabled` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Not 1 if an IP is temp-blocked',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `userName` (`userName`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COMMENT='Some data upon registering is discarded';


DROP TABLE IF EXISTS `levels`;
CREATE TABLE IF NOT EXISTS `levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `accountID` int(11) NOT NULL,
  `audioID` int(11) NOT NULL DEFAULT 0 COMMENT 'Vanilla sound track',
  `songID` int(11) NOT NULL DEFAULT 0,
  `difficulty` text NOT NULL DEFAULT 'NA',
  `demonDiff` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Only used if difficulty is Demon (10)',
  `length` tinyint(1) NOT NULL DEFAULT 0,
  `objects` tinyint(1) NOT NULL DEFAULT 0,
  `coins` tinyint(1) NOT NULL DEFAULT 0,
  `originalID` int(11) NOT NULL DEFAULT 0,
  `originalReuploadID` int(11) DEFAULT NULL COMMENT 'For the level reupload tool',
  `extraString` varchar(255) DEFAULT NULL,
  `downloads` int(11) NOT NULL DEFAULT 0,
  `likes` int(11) NOT NULL DEFAULT 0,
  `featureScoring` int(11) NOT NULL DEFAULT 0 COMMENT 'Prioritized ordering over uploadDate for featured tab',
  `stars` int(11) NOT NULL DEFAULT 0,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `epic` tinyint(1) NOT NULL DEFAULT 0,
  `inHall` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Only used if configured',
  `inMagic` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Only used if configured',
  `bonusCP` int(11) NOT NULL DEFAULT 0,
  `noCP` tinyint(1) NOT NULL DEFAULT 0,
  `uploadDate` bigint(20) NOT NULL DEFAULT current_timestamp(),
  `updateDate` bigint(20) NOT NULL DEFAULT 0,
  `rateDate` bigint(20) NOT NULL DEFAULT 0,
  `requestedStars` tinyint(1) NOT NULL DEFAULT 0,
  `hasLDM` tinyint(1) NOT NULL DEFAULT 0,
  `password` int(6) NOT NULL DEFAULT 0,
  `twoPlayer` tinyint(1) NOT NULL DEFAULT 0,
  `unlisted` tinyint(1) NOT NULL DEFAULT 0,
  `version` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Level data (the actual levels) is stored externally in /data';

DROP TABLE IF EXISTS `quests`;
CREATE TABLE IF NOT EXISTS `quests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `requirement` int(11) NOT NULL COMMENT 'How much of type x to collect',
  `reward` int(11) NOT NULL COMMENT 'How many diamonds rewarded',
  `type` int(11) NOT NULL COMMENT '1=orbs, 2=coins, 3=stars',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COMMENT='At least 3 quests should be saved to allow quests to appear properly';

INSERT INTO `quests` (`id`, `name`, `requirement`, `reward`, `type`) VALUES
(1, 'Pool of Orbs', 100, 10, 1),
(2, 'Search for shiny Silvers', 3, 25, 2),
(3, 'Stargazer', 3, 10, 3),
(4, 'Snatching more Orbs', 250, 15, 1),
(5, 'Could it be Money?', 1, 10, 2),
(6, 'Star Catcher', 10, 50, 3);

DROP TABLE IF EXISTS `userdata`;
CREATE TABLE IF NOT EXISTS `userdata` (
  `id` int(11) NOT NULL,
  `stars` int(11) NOT NULL DEFAULT 0,
  `demons` int(11) NOT NULL DEFAULT 0,
  `starCoins` int(11) NOT NULL DEFAULT 0,
  `userCoins` int(11) NOT NULL DEFAULT 0,
  `diamonds` int(11) NOT NULL DEFAULT 0,
  `iconType` int(11) NOT NULL DEFAULT 0,
  `iconArray` varchar(255) NOT NULL DEFAULT '0,0,0,0,0,0,0,0,0,0,0',
  `leaderboardBanned` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Not checked if acc is disabled',
  `creatorBanned` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'leaderboardBanned will affect this',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `leaderboardBanned` (`leaderboardBanned`),
  KEY `creatorBanned` (`creatorBanned`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='This is not connected to the cloud save data';

DROP TABLE IF EXISTS `dailyquests`;
CREATE TABLE IF NOT EXISTS `dailyquests` (
  `id` int(11) NOT NULL COMMENT 'The order of the quests',
  `questID` int(11) NOT NULL COMMENT 'The ID of this specific quest',
  `expire` timestamp NOT NULL DEFAULT NOW() COMMENT "The timestamp that the quest will expire. This should theoretically be the same for all quests, I just don't know where else to store it",
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Only used for daily quests, otherwise this is unused';

/* This is absolutely required because otherwise quests will not update properly */
INSERT INTO `dailyquests` (`id`, `questID`) VALUES
(1, 1),
(2, 2),
(3, 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
