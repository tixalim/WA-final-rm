-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2025 at 01:29 PM
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
-- Database: `wa-final-rm`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `content`, `created_at`) VALUES
(9, 11, 3, 'Tohle je vibe! Letos jsem poprvé zavařil vlastní rajčata a nikdy nechci zpátky ke konzervám!', '2025-06-03 11:21:02'),
(10, 10, 4, 'Můžeme udělat receptář solarpunkových jídel? Něco jako \'kuchařka budoucnosti\'!', '2025-06-03 11:24:20'),
(11, 12, 4, 'Chceme komunitní zahradu + meditační koutek! Dáme to na zasedání spolku!', '2025-06-03 11:24:46'),
(12, 13, 2, 'Miluju swap akce! Tyhle jsem tam vyměnila super sako za boty.', '2025-06-03 11:26:25');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `content`, `created_at`, `image_path`) VALUES
(10, 2, 'Solarpunková kuchyně – jak vypadá jídlo budoucnosti?', 'Minimalismus, sezónnost a respekt k přírodě – to jsou tři základní ingredience solarpunkové kuchyně. Zapomeň na avokádo z druhého konce světa. V solarpunku se vaří z lokálních plodin, fermentuje, suší, pěstuje doma i sdílí v komunitních kuchyních. Nejde o dogma, ale o vztah k původu a dopadu každého sousta.', '2025-06-03 11:18:32', NULL),
(11, 2, 'Opravy místo odpadu – solarpunkový přístup k věcem', 'Ve světě zahlceném levným odpadem má každý opravený předmět větší hodnotu než ten nový. Šít, pájet, slepovat, upcyklovat – to jsou superschopnosti solarpunkera. A co je nejvíc? Sdílené opravárny a komunitní workshopy místo nákupních center.', '2025-06-03 11:18:53', NULL),
(12, 3, 'Solarpunk a duševní zdraví – zpomalení jako revoluce', 'V kultuře, která neustále tlačí na výkon, multitasking a „busy“ jako statusový symbol, je solarpunk malou, ale hlasitou revolucí. Ne tím, že by křičel – ale tím, že ztiší. Učí nás zpomalit, zhluboka dýchat a vracet se ke kořenům – doslova i obrazně.\r\n\r\nV solarpunku není „produktivitou“ to, kolik e-mailů stihneš za den, ale jak hluboko se spojíš s prostředím, se sebou, s komunitou. Životní tempo se přizpůsobuje rytmu přírody – práce se střídá s odpočinkem, technologie se používají s mírou, a každodenní činnosti nejsou nástrojem výkonu, ale rituálem péče.\r\n\r\nV komunitních zahradách se mluví i mlčí. Důraz na duševní hygienu je stejně silný jako ten na udržitelnou architekturu. Meditace, dechová cvičení, open space pro sdílení emocí – to všechno má v solarpunkových komunitách své pevné místo. A škola? Ta neučí jen matiku a kódování, ale i empatii, sebevědomí, všímavost.\r\n\r\nSolarpunk říká: nejsme stroje. A právě tím nás učí být plně lidmi.', '2025-06-03 11:22:34', NULL),
(13, 4, 'Móda, co neničí planetu – solarpunkový šatník', 'Solarpunková móda není o trendech – je o vztahu. Vztahu ke kousku oblečení, k materiálu, ke člověku, co ho vytvořil. Je to návrat k oblečení, které má smysl. Slow fashion, recyklace, upcyklace, komunitní swapy a vlastní tvorba místo přeplněných e-shopů a impulzivních nákupů.\r\n\r\nPředstav si šatník, který není o množství, ale o příbězích. Šaty ze starých záclon, mikina z přešitých dek, taška z nepotřebného závěsu. Každý kus má duši, nejen značku. V solarpunku se totiž neoblékáme proto, abychom se ukázali – ale abychom se vyjádřili.\r\n\r\nEtická móda ale není jen DIY. Je to i o podpoře lokálních tvůrců, o zodpovědném přístupu k materiálům a o tom, jak se o oblečení staráme. Šít a opravovat je znovu sexy. A výšivka? Ne jen dekorační prvek, ale manifest.', '2025-06-03 11:23:55', NULL),
(14, 2, 'Solarpunk a vzdělávání – když škola znamená víc než známky', 'Jak by vypadala škola, kdyby opravdu připravovala na budoucnost? V solarpunkové vizi není učení o tom, co si zapamatuješ na test, ale co pochopíš, prožiješ, zažiješ. Učíš se venku, mezi stromy. Dotýkáš se hlíny, vody, programuješ s konkrétním cílem – třeba vytvořit automatické zavlažování pro komunitní záhon.\r\n\r\nSolarpunkové vzdělávání není odtržené od světa – je s ním v přímém kontaktu. Neodděluje teorii od praxe. Učí tě, jak věci fungují, ale taky proč na nich záleží. A co je nejzásadnější – podporuje spolupráci místo soutěžení. Skupinové projekty, kde každý přináší svou sílu – někdo kreativitu, jiný logiku, další cit pro detail.\r\n\r\nŠkola v solarpunku zahrnuje i témata jako permakultura, digitální etika, mediální gramotnost, empatie nebo komunitní rozhodování. Učitel není autorita, ale průvodce. Učení je život, ne oddělený prostor.\r\n\r\nA hlavně – každý se učí svým tempem. Protože růst, stejně jako v přírodě, není závod.', '2025-06-03 11:27:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `role`, `created_at`) VALUES
(1, 'admin', '', '$2y$10$GUlufjY.kKAXRkGq37ALl.H8.iu1e0ifMJwfivuByFUEalXIcKoEC', 'admin', '2025-05-31 08:53:33'),
(2, 'Rose', '', '$2y$10$DoSKbwO/LAUeGkkvtFGlgu6M24KaVc8jgzThq6u6QSaz.62WzQPKy', 'user', '2025-05-31 09:38:58'),
(3, 'pepa', '', '$2y$10$UUtdDx4psqzBwMcQUuP1UOWdUO9o8xfvdoa3mV7UXglxlkzTDFhLq', 'user', '2025-06-03 11:20:12'),
(4, 'bob', '', '$2y$10$cJ0S8QvXtbE4AHGTYIL7l.J.uvpJwlGifO/mrk44c2vPzF9PER2rq', 'user', '2025-06-03 11:23:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
