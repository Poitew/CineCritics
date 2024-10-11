-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2024 at 08:34 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moviedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `credenziali`
--

CREATE TABLE `credenziali` (
  `ID` int(11) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(30) DEFAULT NULL,
  `movie_description` text DEFAULT NULL,
  `director` varchar(30) DEFAULT NULL,
  `cover` text DEFAULT NULL,
  `landscape_cover` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `title`, `movie_description`, `director`, `cover`, `landscape_cover`) VALUES
(1, 'Alien 1979', 'The crew of a spacecraft, Nostromo, intercept a distress signal from a planet and set out to investigate it. However, to their horror, they are attacked by an alien which later invades their ship.', ' Ridley Scott', '/film_review/assets/covers/alien.jpg', '/film_review/assets/covers/alien_landscape.jpg'),
(2, 'Donnie Darko', 'Donnie Darko, an awkward teenager, befriends Frank, a figure in a bunny costume only he can see, who informs Donnie that the world will end in 28 days, 6 hours, 42 minutes, and 12 seconds.', 'Richard Kelly', '/film_review/assets/covers/donniedarko.jpg', '/film_review/assets/covers/donniedarko_landscape.jpg'),
(3, 'Inception', 'Cobb steals information from his targets by entering their dreams. He is wanted for his alleged role in his wife\'s murder and his only chance at redemption is to perform a nearly impossible task.', 'Christopher Nolan', '/film_review/assets/covers/inception.jpg', '/film_review/assets/covers/inception_landscape.jpg'),
(4, 'Oppenheimer', 'During World War II, Lt. Gen. Leslie Groves Jr. appoints physicist J. Robert Oppenheimer to work on the top-secret Manhattan Project. Oppenheimer and a team of scientists spend years developing and designing the atomic bomb. Their work comes to fruition on July 16, 1945, as they witness the world\'s first nuclear explosion, forever changing the course of history.', 'Christopher Nolan', '/film_review/assets/covers/oppenheimer.jpg', '/film_review/assets/covers/oppenheimer_landscape.jpg'),
(5, 'The Blair Witch Project', 'Three students decide to go into the Maryland backwoods to cover the mystery behind the Blair Witch incidents. However, they lose their map and things take an unexpected turn.', 'Eduardo Sánchez', '/film_review/assets/covers/blairwitch.jpg', '/film_review/assets/covers/blairwitch_landscape.jpg'),
(6, 'The Dark Knight', 'Batman has a new foe, the Joker, who is an accomplished criminal hell-bent on decimating Gotham City. Together with Gordon and Harvey Dent, Batman struggles to thwart the Joker before it is too late.', 'Christopher Nolan', '/film_review/assets/covers/thedarkknight.jpg', '/film_review/assets/covers/thedarkknight_landscape.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `review` text DEFAULT NULL,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `credenziali`
--
ALTER TABLE `credenziali`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `credenziali`
--
ALTER TABLE `credenziali`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
