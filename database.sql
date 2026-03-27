-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2026 at 06:20 PM
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
-- Database: `chayn_wiki`
--

-- --------------------------------------------------------

--
-- Table structure for table `achievements`
--

CREATE TABLE `achievements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `tier` varchar(255) NOT NULL DEFAULT 'bronze',
  `points` int(11) NOT NULL DEFAULT 10,
  `requirements` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`requirements`)),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `achievements`
--

INSERT INTO `achievements` (`id`, `slug`, `name`, `description`, `icon`, `category`, `tier`, `points`, `requirements`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'first-article', 'First Contribution', 'Create your first wiki article', '✍️', 'contributor', 'bronze', 10, '{\"articles_created\":1}', 1, '2026-01-29 07:18:58', '2026-01-29 07:18:58'),
(2, 'prolific-writer', 'Prolific Writer', 'Create 10 wiki articles', '📚', 'contributor', 'silver', 50, '{\"articles_created\":10}', 1, '2026-01-29 07:18:58', '2026-01-29 07:18:58'),
(3, 'wiki-master', 'Wiki Master', 'Create 50 wiki articles', '🏆', 'contributor', 'gold', 200, '{\"articles_created\":50}', 1, '2026-01-29 07:18:58', '2026-01-29 07:18:58'),
(4, 'legend', 'Living Legend', 'Create 100 wiki articles', '👑', 'contributor', 'platinum', 500, '{\"articles_created\":100}', 1, '2026-01-29 07:18:58', '2026-01-29 07:18:58'),
(5, 'first-edit', 'Editor', 'Make your first edit to an existing article', '✏️', 'editor', 'bronze', 5, '{\"edits_made\":1}', 1, '2026-01-29 07:18:58', '2026-01-29 07:18:58'),
(6, 'dedicated-editor', 'Dedicated Editor', 'Make 50 edits', '📝', 'editor', 'silver', 75, '{\"edits_made\":50}', 1, '2026-01-29 07:18:58', '2026-01-29 07:18:58'),
(7, 'perfectionist', 'Perfectionist', 'Make 200 edits', '💎', 'editor', 'gold', 250, '{\"edits_made\":200}', 1, '2026-01-29 07:18:58', '2026-01-29 07:18:58'),
(8, 'hip-hop-head', 'Hip Hop Head', 'Create 10 articles about hip-hop', '🎤', 'expert', 'silver', 100, '{\"category_articles\":{\"hip-hop\":10}}', 1, '2026-01-29 07:18:58', '2026-01-29 07:18:58'),
(9, 'rock-scholar', 'Rock Scholar', 'Create 10 articles about rock music', '🎸', 'expert', 'silver', 100, '{\"category_articles\":{\"rock\":10}}', 1, '2026-01-29 07:18:58', '2026-01-29 07:18:58'),
(10, 'pop-expert', 'Pop Expert', 'Create 10 articles about pop music', '🌟', 'expert', 'silver', 100, '{\"category_articles\":{\"pop\":10}}', 1, '2026-01-29 07:18:59', '2026-01-29 07:18:59'),
(11, 'week-streak', 'Week Warrior', 'Maintain a 7-day contribution streak', '🔥', 'streak', 'bronze', 25, '{\"streak_days\":7}', 1, '2026-01-29 07:18:59', '2026-01-29 07:18:59'),
(12, 'month-streak', 'Monthly Champion', 'Maintain a 30-day contribution streak', '⚡', 'streak', 'gold', 150, '{\"streak_days\":30}', 1, '2026-01-29 07:18:59', '2026-01-29 07:18:59'),
(13, 'helpful', 'Helpful', 'Have your articles viewed 1,000 times', '💡', 'community', 'bronze', 20, '{\"total_views\":1000}', 1, '2026-01-29 07:18:59', '2026-01-29 07:18:59'),
(14, 'influencer', 'Influencer', 'Have your articles viewed 10,000 times', '🌍', 'community', 'silver', 100, '{\"total_views\":10000}', 1, '2026-01-29 07:18:59', '2026-01-29 07:18:59'),
(15, 'viral', 'Viral', 'Have your articles viewed 100,000 times', '🚀', 'community', 'platinum', 500, '{\"total_views\":100000}', 1, '2026-01-29 07:18:59', '2026-01-29 07:18:59'),
(16, 'early-adopter', 'Early Adopter', 'Join ChaynWiki in its first year', '🌱', 'special', 'gold', 100, '{\"joined_before\":\"2027-01-01\"}', 1, '2026-01-29 07:18:59', '2026-01-29 07:18:59'),
(17, 'ai-pioneer', 'AI Pioneer', 'Use AI to generate 5 article drafts', '🤖', 'special', 'silver', 50, '{\"ai_generations\":5}', 1, '2026-01-29 07:18:59', '2026-01-29 07:18:59');

-- --------------------------------------------------------

--
-- Table structure for table `ai_generations`
--

CREATE TABLE `ai_generations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL DEFAULT 'llama3',
  `prompt` text NOT NULL,
  `response` longtext DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `tokens_used` int(11) DEFAULT NULL,
  `generation_time` double DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ai_generations`
--

INSERT INTO `ai_generations` (`id`, `user_id`, `type`, `model`, `prompt`, `response`, `status`, `tokens_used`, `generation_time`, `metadata`, `created_at`, `updated_at`) VALUES
(1, NULL, 'article', 'llama3', 'Write a comprehensive music wiki article about \"hello how are you?\".\r\n\r\nStructure the article with relevant markdown headers (##) based on the topic.\r\nInclude factual information, historical context, and cultural significance.\r\nWrite in an encyclopedic, neutral tone.\r\nBe thorough but concise. Aim for well-researched, informative content.', NULL, 'failed', NULL, 2.28, '{\"topic\":\"hello how are you?\",\"category\":\"general\"}', '2026-01-29 08:20:38', '2026-01-29 08:20:38'),
(2, NULL, 'article', 'llama3', 'Write a comprehensive music wiki article about \"hello how are you?\".\r\n\r\nStructure the article with relevant markdown headers (##) based on the topic.\r\nInclude factual information, historical context, and cultural significance.\r\nWrite in an encyclopedic, neutral tone.\r\nBe thorough but concise. Aim for well-researched, informative content.', 'This is a **simulated AI response** for testing the UI.\n\n# Introduction\nThis content is generated because Ollama is not actually running on the server, but we want to verify the design.\n\n## simulated Section\n- Item 1\n- Item 2\n- Item 3\n\nIt allows us to see how the markdown rendering looks without needing the heavy AI model running in the background.', 'completed', NULL, 0, '{\"topic\":\"hello how are you?\",\"category\":\"general\"}', '2026-01-29 08:23:39', '2026-01-29 08:23:39'),
(3, NULL, 'article', 'llama3', 'Write a comprehensive music wiki article about the artist/band \"Arijit singh\".\r\n\r\nInclude these sections with markdown headers (##):\r\n## Early Life and Background\r\n- Origins, formation, early influences\r\n\r\n## Career\r\n- Career timeline, major releases, evolution\r\n\r\n## Musical Style\r\n- Genre, influences, signature sound, production style\r\n\r\n## Discography Highlights\r\n- Key albums and singles, collaborations\r\n\r\n## Awards and Recognition\r\n- Major awards, chart achievements, records\r\n\r\n## Legacy and Influence\r\n- Impact on music, influenced artists, cultural significance\r\n\r\nWrite in an encyclopedic, neutral tone.', 'This is a **simulated AI response** for testing the UI.\n\n# Introduction\nThis content is generated because Ollama is not actually running on the server, but we want to verify the design.\n\n## simulated Section\n- Item 1\n- Item 2\n- Item 3\n\nIt allows us to see how the markdown rendering looks without needing the heavy AI model running in the background.', 'completed', NULL, 0, '{\"topic\":\"Arijit singh\",\"category\":\"artist\"}', '2026-01-29 09:01:52', '2026-01-29 09:01:52'),
(4, NULL, 'article', 'llama3', 'Write a comprehensive music wiki article about \"Arijit singh\".\r\n\r\nStructure the article with relevant markdown headers (##) based on the topic.\r\nInclude factual information, historical context, and cultural significance.\r\nWrite in an encyclopedic, neutral tone.\r\nBe thorough but concise. Aim for well-researched, informative content.', '# Dynamic Musical Insight\n\nThis is a sample of AI-generated content for the topic. It demonstrates how the system structures information including core history, stylistic elements, and cultural significance. If Ollama is running, this will be replaced with real-time analysis.\n\n## Core Characteristics\n- Multi-tonal arrangements\n- Rhythmic complexity\n- Lyrical juxtaposition\n\n## Historical Context\nEmerging as a response to traditional structures, this style focuses on blending classical foundations with modern interpretive freedom.', 'completed', NULL, 2.38, '{\"topic\":\"Arijit singh\",\"category\":\"general\"}', '2026-01-29 10:54:13', '2026-01-29 10:54:13'),
(5, NULL, 'article', 'llama3', 'Write a comprehensive music wiki article about the artist/band \"Arijit singh\".\r\n\r\nInclude these sections with markdown headers (##):\r\n## Early Life and Background\r\n- Origins, formation, early influences\r\n\r\n## Career\r\n- Career timeline, major releases, evolution\r\n\r\n## Musical Style\r\n- Genre, influences, signature sound, production style\r\n\r\n## Discography Highlights\r\n- Key albums and singles, collaborations\r\n\r\n## Awards and Recognition\r\n- Major awards, chart achievements, records\r\n\r\n## Legacy and Influence\r\n- Impact on music, influenced artists, cultural significance\r\n\r\nWrite in an encyclopedic, neutral tone.', '# Arijit singh - Overview\n\nArijit singh represents a significant chapter in contemporary music, known for its unique blend of traditional foundations and modern innovative techniques. This style has captured global attention through its emotional resonance and technical precision.\n\n## Core Characteristics\n- **Sophisticated Arrangement**: Meticulous attention to tonal balance and melodic flow.\n- **Thematic Depth**: Incorporating complex narratives and philosophical undertones.\n- **Rhythmic Innovation**: Shifting standard patterns into more interpretive, fluid structures.\n\n## Historical Evolution\nEmerging as a response to the rigid structures of previous eras, this movement focuses on the freedom of expression. Artists in this space often experiment with sub-tonal textures and cross-genre fusion, creating a soundscape that is both familiar and avant-garde.\n\n## Global Impact\nBeyond the auditory experience, Arijit singh has influenced visual arts, fashion, and the broader cultural conversation, serving as a medium for social commentary and personal identity exploration.', 'completed', NULL, 2.25, '{\"topic\":\"Arijit singh\",\"category\":\"artist\"}', '2026-01-29 10:56:25', '2026-01-29 10:56:25'),
(6, NULL, 'article', 'llama3', 'Write a comprehensive music wiki article about \"What is the age of arijit singh?\".\r\n\r\nStructure the article with relevant markdown headers (##) based on the topic.\r\nInclude factual information, historical context, and cultural significance.\r\nWrite in an encyclopedic, neutral tone.\r\nBe thorough but concise. Aim for well-researched, informative content.', '# What is the age of arijit singh? - Overview\n\nWhat is the age of arijit singh? represents a significant chapter in contemporary music, known for its unique blend of traditional foundations and modern innovative techniques. This style has captured global attention through its emotional resonance and technical precision.\n\n## Core Characteristics\n- **Sophisticated Arrangement**: Meticulous attention to tonal balance and melodic flow.\n- **Thematic Depth**: Incorporating complex narratives and philosophical undertones.\n- **Rhythmic Innovation**: Shifting standard patterns into more interpretive, fluid structures.\n\n## Historical Evolution\nEmerging as a response to the rigid structures of previous eras, this movement focuses on the freedom of expression. Artists in this space often experiment with sub-tonal textures and cross-genre fusion, creating a soundscape that is both familiar and avant-garde.\n\n## Global Impact\nBeyond the auditory experience, What is the age of arijit singh? has influenced visual arts, fashion, and the broader cultural conversation, serving as a medium for social commentary and personal identity exploration.', 'completed', NULL, 2.26, '{\"topic\":\"What is the age of arijit singh?\",\"category\":\"general\"}', '2026-01-30 09:05:01', '2026-01-30 09:05:01'),
(7, NULL, 'article', 'llama3', 'Write a comprehensive music wiki article about \"What is the age of arijit singh??\".\r\n\r\nStructure the article with relevant markdown headers (##) based on the topic.\r\nInclude factual information, historical context, and cultural significance.\r\nWrite in an encyclopedic, neutral tone.\r\nBe thorough but concise. Aim for well-researched, informative content.', '# What is the age of arijit singh?? - Overview\n\nWhat is the age of arijit singh?? represents a significant chapter in contemporary music, known for its unique blend of traditional foundations and modern innovative techniques. This style has captured global attention through its emotional resonance and technical precision.\n\n## Core Characteristics\n- **Sophisticated Arrangement**: Meticulous attention to tonal balance and melodic flow.\n- **Thematic Depth**: Incorporating complex narratives and philosophical undertones.\n- **Rhythmic Innovation**: Shifting standard patterns into more interpretive, fluid structures.\n\n## Historical Evolution\nEmerging as a response to the rigid structures of previous eras, this movement focuses on the freedom of expression. Artists in this space often experiment with sub-tonal textures and cross-genre fusion, creating a soundscape that is both familiar and avant-garde.\n\n## Global Impact\nBeyond the auditory experience, What is the age of arijit singh?? has influenced visual arts, fashion, and the broader cultural conversation, serving as a medium for social commentary and personal identity exploration.', 'completed', NULL, 2.23, '{\"topic\":\"What is the age of arijit singh??\",\"category\":\"general\"}', '2026-01-30 09:05:47', '2026-01-30 09:05:47'),
(8, 1, 'article', 'llama3', 'Write a comprehensive music wiki article about \"Arijit singh\".\r\n\r\nStructure the article with relevant markdown headers (##) based on the topic.\r\nInclude factual information, historical context, and cultural significance.\r\nWrite in an encyclopedic, neutral tone.\r\nBe thorough but concise. Aim for well-researched, informative content.', '# Arijit singh - Overview\n\nArijit singh represents a significant chapter in contemporary music, known for its unique blend of traditional foundations and modern innovative techniques. This style has captured global attention through its emotional resonance and technical precision.\n\n## Core Characteristics\n- **Sophisticated Arrangement**: Meticulous attention to tonal balance and melodic flow.\n- **Thematic Depth**: Incorporating complex narratives and philosophical undertones.\n- **Rhythmic Innovation**: Shifting standard patterns into more interpretive, fluid structures.\n\n## Historical Evolution\nEmerging as a response to the rigid structures of previous eras, this movement focuses on the freedom of expression. Artists in this space often experiment with sub-tonal textures and cross-genre fusion, creating a soundscape that is both familiar and avant-garde.\n\n## Global Impact\nBeyond the auditory experience, Arijit singh has influenced visual arts, fashion, and the broader cultural conversation, serving as a medium for social commentary and personal identity exploration.', 'completed', NULL, 2.35, '{\"topic\":\"Arijit singh\",\"category\":\"general\"}', '2026-01-30 11:10:14', '2026-01-30 11:10:14'),
(9, NULL, 'chat', 'ollama/llama3', 'What genres are trending right now?', 'I\'m currently in offline mode because the AI server (Ollama) is unreachable. How can I help you with the static wiki data?', 'completed', NULL, 2.3160109519958, '{\"has_context\":false,\"history_count\":1}', '2026-01-31 09:45:56', '2026-01-31 09:45:56'),
(10, NULL, 'chat', 'ollama/llama3', 'Tell me about the history of jazz', 'I\'m currently in offline mode because the AI server (Ollama) is unreachable. How can I help you with the static wiki data?', 'completed', NULL, 2.3547320365906, '{\"has_context\":false,\"history_count\":1}', '2026-01-31 12:04:01', '2026-01-31 12:04:01'),
(11, 1, 'chat', 'ollama/llama3', 'What genres are trending right now?', 'I\'m currently in offline mode because the AI server (Ollama) is unreachable. How can I help you with the static wiki data?', 'completed', NULL, 2.3201289176941, '{\"has_context\":false,\"history_count\":1}', '2026-01-31 12:56:04', '2026-01-31 12:56:04'),
(12, 1, 'chat', 'ollama/llama3', 'Tell me about the history of jazz', 'I\'m currently in static mode. My AI uplink is unreachable.', 'completed', NULL, 1.2185461521149, '{\"has_context\":false,\"history_count\":1}', '2026-01-31 13:05:27', '2026-01-31 13:05:27'),
(13, 1, 'chat', 'ollama/llama3', 'Tell me about the history of jazz', 'I am currently operating in **Demo Mode**. While my full AI uplink is being configured, I can tell you that ChaynWiki is a premium archival project dedicated to preserving the sonic history of global music. How can I help you explore our records today?', 'completed', NULL, 0.95736312866211, '{\"has_context\":false,\"history_count\":1}', '2026-01-31 13:06:31', '2026-01-31 13:06:31'),
(14, 1, 'chat', 'ollama/llama3', 'Tell me about the history of jazz', 'I am currently operating in **Demo Mode**. While my full AI uplink is being configured, I can tell you that ChaynWiki is a premium archival project dedicated to preserving the sonic history of global music. How can I help you explore our records today?', 'completed', NULL, 1.1957859992981, '{\"has_context\":false,\"history_count\":1}', '2026-01-31 13:08:44', '2026-01-31 13:08:44'),
(15, 1, 'chat', 'ollama/llama3', 'Tell me about the history of jazz', '**The History of Jazz: A Rich and Diverse Legacy**\n==============================================\n\nJazz is a unique and complex genre that has evolved over the past century, influenced by a variety of musical traditions and social factors. Here\'s a brief overview:\n\n### **Early Beginnings (1900s-1920s)**\n\n* Jazz originated in the southern United States, particularly in New Orleans, Louisiana\n* African American work songs, spirituals, and blues merged with European instrumentation and harmonies\n* Influenced by ragtime, marching bands, and Creole music\n* Key figures: Buddy Bolden, Jelly Roll Morton, and Sidney Bechet\n\n### **The Jazz Age (1920s-1930s)**\n\n* Jazz spread throughout the United States, with cities like Chicago, New York, and Kansas City becoming major jazz hubs\n* Big bands, led by Duke Ellington, Count Basie, and Benny Goodman, gained popularity\n* Swing music and dance became a cultural phenomenon\n* Notable musicians: Louis Armstrong, Bessie Smith, and Ethel Waters\n\n### **Bebop and Cool Jazz (1940s-1950s)**\n\n* Bebop, led by Charlie Parker, Dizzy Gillespie, and Thelonious Monk, revolutionized jazz with fast tempos and complex harmonies\n* Cool jazz, exemplified by Miles Davis and Chet Baker, emphasized relaxed, introspective playing\n* West Coast jazz emerged, characterized by a more subdued, introspective sound\n* Influential musicians: Billie Holiday, Ella Fitzgerald, and Oscar Peterson\n\n### **Free Jazz and Fusion (1960s-1970s)**\n\n* Free jazz, led by Ornette Coleman, John Coltrane, and Cecil Taylor, pushed the boundaries of traditional jazz\n* Fusion jazz, exemplified by Miles Davis, Herbie Hancock, and Weather Report, incorporated rock, funk, and electronic elements\n* Jazz-rock fusion and acid jazz gained popularity\n* Notable musicians: Jimi Hendrix, Janis Joplin, and Stevie Wonder\n\n### **Modern and Contemporary Jazz (1980s-present)**\n\n* Jazz continued to diversify, incorporating elements from hip-hop, R&B, and world music\n* Smooth jazz, led by Kenny G and George Benson, became a commercial success\n* Contemporary jazz musicians, such as Kamasi Washington, Robert Glasper, and Esperanza Spalding, continue to innovate and push the genre forward\n\n**Key Themes and Influences**\n\n* **African American culture and experience**: Jazz has always been deeply rooted in the African American community, reflecting the struggles, triumphs, and creativity of black Americans\n* **Improvisation and experimentation**: Jazz is characterized by its emphasis on improvisation, allowing musicians to express themselves freely and push the boundaries of the genre\n* **Global influences**: Jazz has been shaped by a wide range of musical traditions, from African and European folk music to Latin American and Asian rhythms\n\n**Recommended Listening**\n\n* Louis Armstrong: \"What a Wonderful World\"\n* Miles Davis: \"Kind of Blue\"\n* John Coltrane: \"A Love Supreme\"\n* Billie Holiday: \"God Bless the Child\"\n* Kamasi Washington: \"The Epic\"\n\n**Related Topics**\n\n* Blues music and its influence on jazz\n* The role of jazz in social justice movements\n* The intersection of jazz and other genres, such as rock, hip-hop, and electronic music\n\nI hope this brief history of jazz has sparked your interest in this rich and diverse genre!', 'completed', NULL, 5.8964040279388, '{\"has_context\":false,\"history_count\":1}', '2026-01-31 13:10:39', '2026-01-31 13:10:39'),
(16, 1, 'article', 'llama3', 'Write a comprehensive music wiki article about the artist/band \"Arijit singh\".\r\n\r\nInclude these sections with markdown headers (##):\r\n## Early Life and Background\r\n- Origins, formation, early influences\r\n\r\n## Career\r\n- Career timeline, major releases, evolution\r\n\r\n## Musical Style\r\n- Genre, influences, signature sound, production style\r\n\r\n## Discography Highlights\r\n- Key albums and singles, collaborations\r\n\r\n## Awards and Recognition\r\n- Major awards, chart achievements, records\r\n\r\n## Legacy and Influence\r\n- Impact on music, influenced artists, cultural significance\r\n\r\nWrite in an encyclopedic, neutral tone.', '## Early Life and Background\nArijit Singh is a Indian playback singer born on April 25, 1987, in Jiaganj, Murshidabad, West Bengal, India. He was raised in a musical family and was exposed to various genres of music from a young age. Singh\'s mother, Kakkar Singh, was a homemaker, and his father, Rajendra Prasad Singh, was an engineer. He has a sister, Amrita Singh, who is also a singer. Arijit\'s early influences included Indian classical music, ghazals, and Bollywood music. He was trained in classical music by his mother and later by Rajendra Prasad Hazari, a tabla player.\n\n## Career\nArijit Singh\'s music career began when he participated in the reality TV show \"Fame Gurukul\" in 2005, where he was eliminated, but his talent was noticed by composer Pritam, who later offered him a chance to sing in his compositions. Singh\'s breakthrough came in 2011 with the song \"Phir Le Aya Dil\" from the film \"Barfi!\", which was composed by Pritam. He then went on to sing for various Bollywood films, including \"Cocktail\", \"Ashiqui 2\", and \"Yeh Jawaani Hai Deewani\". His career gained momentum with the release of the song \"Tum Hi Ho\" from the film \"Aashiqui 2\", which became a massive hit. Since then, Singh has become one of the most sought-after playback singers in Bollywood, singing for numerous films and collaborating with prominent composers.\n\n## Musical Style\nArijit Singh\'s musical style is characterized by his soulful and emotive voice, which has become his signature sound. He is known for his versatility and ability to sing in various genres, including romantic ballads, upbeat dance tracks, and classical numbers. Singh\'s influences include Indian classical music, ghazals, and Bollywood music, which are reflected in his singing style. His production style often involves intricate vocal arrangements and harmonies, which add depth and complexity to his songs. Singh has experimented with different genres, including Sufi, rock, and pop, and has collaborated with various composers to create unique and innovative sounds.\n\n## Discography Highlights\nSome of Arijit Singh\'s key albums and singles include:\n* \"Phir Le Aya Dil\" from the film \"Barfi!\" (2011)\n* \"Tum Hi Ho\" from the film \"Aashiqui 2\" (2013)\n* \"Chahoon Main Ya Naa\" from the film \"Aashiqui 2\" (2013)\n* \"Muskurane\" from the film \"CityLights\" (2014)\n* \"Samjhawan\" from the film \"Humpty Sharma Ki Dulhania\" (2014)\n* \"Gerua\" from the film \"Dilwale\" (2015)\n* \"Ae Dil Hai Mushkil\" from the film \"Ae Dil Hai Mushkil\" (2016)\n* \"Enna Sona\" from the film \"OK Jaanu\" (2017)\nSingh has collaborated with prominent composers, including Pritam, Vishal-Shekhar, and Shankar-Ehsaan-Loy, and has sung for various Bollywood films, including \"Cocktail\", \"Ashiqui 2\", \"Yeh Jawaani Hai Deewani\", and \"Dilwale\".\n\n## Awards and Recognition\nArijit Singh has received numerous awards and nominations for his work, including:\n* National Film Award for Best Male Playback Singer for the song \"Binte Dil\" from the film \"Padmaavat\" (2019)\n* Filmfare Award for Best Male Playback Singer for the song \"Tum Hi Ho\" from the film \"Aashiqui 2\" (2014)\n* Zee Cine Award for Best Male Playback Singer for the song \"Samjhawan\" from the film \"Humpty Sharma Ki Dulhania\" (2015)\n* Mirchi Music Award for Male Vocalist of the Year for the song \"Ae Dil Hai Mushkil\" from the film \"Ae Dil Hai Mushkil\" (2017)\nSingh has also broken various records, including becoming the first Indian singer to have three songs in the top 10 of the UK Asian Music Chart.\n\n## Legacy and Influence\nArijit Singh has had a significant impact on the music industry, particularly in Bollywood. He has been credited with revitalizing the playback singing scene and has inspired a new generation of singers. Singh\'s soulful and emotive voice has become a benchmark for male playback singers, and his versatility has paved the way for other singers to experiment with different genres. He has also been recognized for his contributions to Indian music, including being awarded the National Film Award for Best Male Playback Singer. Singh\'s cultural significance extends beyond the music industry, as he has become a cultural icon and a symbol of Indian music\'s global reach.', 'completed', NULL, 4.5, '{\"topic\":\"Arijit singh\",\"category\":\"artist\"}', '2026-01-31 13:11:32', '2026-01-31 13:11:32'),
(17, NULL, 'chat', 'ollama/llama3', 'Who influenced modern hip hop?', '**Influences on Modern Hip Hop**\n================================\n\nModern hip hop has been shaped by a diverse range of artists, genres, and cultural movements. Some key influences include:\n\n* **Old-School Hip Hop Pioneers**:\n	+ DJ Kool Herc\n	+ Grandmaster Flash\n	+ Afrika Bambaataa\n* **Golden Age Hip Hop**:\n	+ Tupac Shakur\n	+ The Notorious B.I.G.\n	+ Nas\n	+ Jay-Z\n* **Southern Hip Hop**:\n	+ OutKast\n	+ UGK\n	+ Lil Jon\n* **West Coast Hip Hop**:\n	+ Dr. Dre\n	+ Snoop Dogg\n	+ Ice Cube\n* **East Coast Hip Hop**:\n	+ The Wu-Tang Clan\n	+ Beastie Boys\n	+ LL Cool J\n* **Trap and Drill**:\n	+ Gucci Mane\n	+ Lil Wayne\n	+ Chief Keef\n* **Contemporary Artists**:\n	+ Kendrick Lamar\n	+ J. Cole\n	+ Chance the Rapper\n	+ Drake\n\nThese artists, among many others, have contributed to the evolution of hip hop, experimenting with new sounds, styles, and themes. **Related topics** to explore include the history of hip hop, the impact of social justice on hip hop, and the intersection of hip hop with other genres like R&B and electronic music.', 'completed', NULL, 1.6286418437958, '{\"has_context\":false,\"history_count\":1}', '2026-02-03 13:21:16', '2026-02-03 13:21:16'),
(18, NULL, 'article', 'llama3', 'Write a comprehensive music wiki article about the song \"test\".\n\nInclude these sections with markdown headers (##):\n## Background\n- Recording history, production details, inspiration\n\n## Composition\n- Musical analysis, key, tempo, instrumentation\n\n## Lyrics\n- Lyrical themes, meaning, notable lines (do not include full lyrics due to copyright)\n\n## Reception\n- Critical reception, chart performance, certifications\n\n## Cultural Impact\n- Use in media, covers, samples, influence\n\n## Legacy\n- Long-term significance, how it\'s remembered today\n\nWrite in an encyclopedic, neutral tone. Use facts where known, and be clear when speculating.', '## Background\nThe song \"Test\" is a musical composition with limited available information. Due to the lack of specificity, it is challenging to provide detailed background information on the song. However, if we were to speculate, it is possible that \"Test\" could be an experimental track, created to push the boundaries of sound and music production. The recording history and production details of the song are unclear, and without more context, it is difficult to determine the inspiration behind its creation.\n\n## Composition\nFrom a musical analysis perspective, without access to the actual song, it is impossible to provide an accurate description of its composition. The key, tempo, and instrumentation of \"Test\" are unknown, making it challenging to analyze its musical structure. If we were to assume that \"Test\" is an electronic or experimental track, it may feature a combination of digital and analog instruments, with a focus on sound design and texture. However, this is purely speculative, and the actual composition of the song could be entirely different.\n\n## Lyrics\nThe lyrical themes and meaning of \"Test\" are unclear, as the song\'s lyrics are not publicly available. It is possible that the song\'s lyrics explore themes of experimentation, self-discovery, or social commentary, but without more context, it is difficult to determine the intended message. Notable lines from the song are also unknown, making it challenging to analyze the lyrical content.\n\n## Reception\nThe critical reception of \"Test\" is unknown, as there is limited information available about the song. It is possible that the song received positive or negative reviews from music critics, but without access to reviews or ratings, it is difficult to determine its reception. The song\'s chart performance and certifications are also unclear, making it challenging to assess its commercial success.\n\n## Cultural Impact\nThe cultural impact of \"Test\" is unclear, as the song\'s usage in media, covers, samples, and influence are unknown. It is possible that the song has been featured in films, television shows, or commercials, but without more information, it is difficult to determine its reach. The song may have inspired other artists or influenced the development of specific genres, but without concrete evidence, this is speculative.\n\n## Legacy\nThe long-term significance of \"Test\" is uncertain, as the song\'s impact on the music industry and its lasting influence are unclear. It is possible that the song has been forgotten or overlooked, or that it has developed a cult following over time. Without more information, it is challenging to determine how \"Test\" is remembered today, or whether it has had a lasting impact on the music world. If more context or information becomes available, a more accurate assessment of the song\'s legacy can be made.', 'completed', NULL, 2.85, '{\"topic\":\"test\",\"category\":\"song\"}', '2026-02-08 11:45:38', '2026-02-08 11:45:38'),
(19, NULL, 'article', 'llama3', 'Write a comprehensive music wiki article about \"test test\".\n\nStructure the article with relevant markdown headers (##) based on the topic.\nInclude factual information, historical context, and cultural significance.\nWrite in an encyclopedic, neutral tone.\nBe thorough but concise. Aim for well-researched, informative content.', '## Introduction to \"Test Test\"\n\"Test test\" is not a specific song or music-related term with a rich history or cultural significance. However, in the context of music and audio technology, \"test test\" is often used as a phrase to check the quality and functionality of audio equipment, such as microphones, speakers, and sound systems.\n\n## Historical Context\nThe use of \"test test\" as a test phrase dates back to the early days of radio broadcasting and public address systems. In the 1920s and 1930s, audio engineers would use simple phrases like \"test test\" or \"one, two, three\" to check the audio levels, tone, and clarity of their equipment. This practice has continued to the present day, with \"test test\" remaining a common phrase used to test audio equipment.\n\n## Cultural Significance\nWhile \"test test\" itself is not a culturally significant phrase, its use in the music industry and audio technology has played a crucial role in ensuring the quality of sound reproduction. The phrase has become a ubiquitous part of the audio testing process, and its use is often taken for granted. However, the importance of \"test test\" lies in its ability to help audio engineers and technicians identify and troubleshoot issues with their equipment, resulting in better sound quality for listeners.\n\n## Technical Aspects\nFrom a technical perspective, \"test test\" is often used to test the frequency response, signal-to-noise ratio, and overall audio quality of a system. The phrase is typically spoken in a neutral tone, with a moderate volume and pitch, to provide a baseline for audio engineers to adjust and optimize their equipment. The use of \"test test\" can also help identify issues with audio equipment, such as distortion, echo, or frequency imbalances.\n\n## Conclusion\nIn conclusion, while \"test test\" may not be a specific song or music-related term with a rich history, its use in the music industry and audio technology has played a significant role in ensuring the quality of sound reproduction. The phrase has become an essential part of the audio testing process, and its importance lies in its ability to help audio engineers and technicians identify and troubleshoot issues with their equipment.', 'completed', NULL, 2.87, '{\"topic\":\"test test\",\"category\":\"general\"}', '2026-02-08 11:48:21', '2026-02-08 11:48:21'),
(20, NULL, 'chat', 'ollama/llama3', 'Who influenced modern hip hop?', '**Influential Figures in Modern Hip Hop**\n=====================================\n\nModern hip hop has been shaped by a diverse range of artists, producers, and DJs. Some key figures who have influenced the genre include:\n\n* **The Golden Age Pioneers**:\n	+ DJ Kool Herc: Often credited as the founder of hip hop\n	+ Grandmaster Flash: Developed DJing techniques and helped popularize hip hop\n	+ Afrika Bambaataa: Founded the Zulu Nation and helped spread hip hop culture\n* **Old-School Rappers**:\n	+ Run-DMC: Pioneered hip hop\'s transition to mainstream success\n	+ The Beastie Boys: Brought hip hop to a wider audience with their unique blend of humor and style\n	+ LL Cool J: One of the first hip hop artists to achieve commercial success\n* **West Coast Legends**:\n	+ Tupac Shakur: A powerful and influential voice in hip hop, known for his storytelling and social commentary\n	+ Dr. Dre: A visionary producer and rapper who helped shape the sound of West Coast hip hop\n	+ Snoop Dogg: A iconic rapper and entertainer who has remained relevant for decades\n* **East Coast Influencers**:\n	+ The Notorious B.I.G.: A charismatic and skilled rapper who helped define the East Coast sound\n	+ Jay-Z: A successful rapper and entrepreneur who has had a lasting impact on hip hop\n	+ Nas: A highly respected lyricist and poet who has inspired a generation of rappers\n* **Southern Trailblazers**:\n	+ OutKast: A innovative and experimental duo that pushed the boundaries of hip hop\n	+ Lil Jon: A producer and rapper who helped popularize the crunk subgenre\n	+ UGK: A influential group from Texas that helped shape the sound of Southern hip hop\n\nThese individuals, along with many others, have contributed to the evolution of hip hop into the diverse and vibrant genre it is today. **Related topics**: The history of hip hop, regional hip hop styles, and the impact of hip hop on popular culture.', 'completed', NULL, 2.6920299530029, '{\"has_context\":false,\"history_count\":1}', '2026-02-08 12:10:01', '2026-02-08 12:10:01'),
(21, NULL, 'chat', 'ollama/llama3', 'Who influenced modern hip hop?', '**Influential Figures in Modern Hip Hop**\n\nModern hip hop has been shaped by a diverse range of artists, producers, and DJs. Some key figures who have influenced the genre include:\n\n* **The Golden Age Pioneers**:\n	+ DJ Kool Herc: Considered the father of hip hop, he developed the breakbeat DJing style.\n	+ Grandmaster Flash: Innovated DJing techniques and helped launch hip hop into the mainstream.\n	+ Afrika Bambaataa: Founded the Zulu Nation and played a crucial role in hip hop\'s early development.\n* **Old-School Rappers**:\n	+ Run-DMC: Brought hip hop to a wider audience and influenced the genre\'s early sound.\n	+ The Beastie Boys: Fused hip hop with rock and punk, creating a unique sound.\n	+ LL Cool J: Paved the way for future hip hop artists with his lyrical style and commercial success.\n* **West Coast Legends**:\n	+ Tupac Shakur: Addressed social issues and told stories of life in the inner city.\n	+ Dr. Dre: Revolutionized hip hop production and launched the careers of numerous artists.\n	+ Snoop Dogg: Popularized the G-Funk sound and became a hip hop icon.\n* **East Coast Innovators**:\n	+ The Notorious B.I.G.: Told vivid stories of life in New York City and helped shape the East Coast sound.\n	+ Jay-Z: Built a hip hop empire through his music, entrepreneurship, and innovative marketing.\n	+ Nas: Elevated lyricism and poetic storytelling in hip hop.\n* **Southern Influencers**:\n	+ OutKast: Experimented with innovative production and pushed the boundaries of hip hop.\n	+ Lil Jon: Popularized the crunk subgenre and brought high-energy beats to the mainstream.\n	+ Kanye West: Integrated hip hop with electronic and soul music, influencing a new generation of artists.\n\nThese individuals, along with many others, have contributed to the evolution of modern hip hop. Their innovative styles, lyricism, and production techniques have inspired a wide range of artists and subgenres within the genre.', 'completed', NULL, 2.4266710281372, '{\"has_context\":false,\"history_count\":1}', '2026-02-08 12:27:17', '2026-02-08 12:27:17'),
(22, NULL, 'chat', 'ollama/llama3', 'What genres are trending right now?', '**Current Trending Genres:**\n\n1. **Hyperpop**: A fusion of pop, electronic, and hip-hop elements, characterized by its experimental and eclectic sound.\n2. **Emo-Rap**: A subgenre of hip-hop that combines emotional lyrics with aggressive, punk-influenced beats.\n3. **Afrobeats**: A genre originating from West Africa, blending traditional Yoruba music with elements of jazz, fuji, and hip-hop.\n4. **Latin Trap**: A subgenre of Latin music that combines trap beats with Latin American rhythms and lyrics.\n5. **Indie Folk**: A genre that emphasizes acoustic instrumentation and introspective, often poetic lyrics.\n\n**Notable Sub-Genres:**\n\n* **Drill**: A subgenre of hip-hop that originated in Chicago, characterized by its dark, gritty sound and often explicit lyrics.\n* **Vaporwave**: A microgenre that emerged in the 2010s, characterized by its dreamy, nostalgia-tinged sound and often experimental approach.\n\n**Popular Crossover Genres:**\n\n* **Pop-Rap**: A fusion of pop and hip-hop elements, often featuring catchy hooks and melodies.\n* **Electronic Dance Music (EDM)**: A broad range of genres, including house, techno, and trance, often featured in clubs and festivals.\n\nThese genres are currently gaining popularity, but trends can change quickly. If you\'re interested in exploring more, I\'d be happy to provide recommendations or discuss specific artists and albums within these genres.', 'completed', NULL, 2.0408420562744, '{\"has_context\":false,\"history_count\":1}', '2026-02-08 12:29:59', '2026-02-08 12:29:59'),
(23, 1, 'article', 'llama3', 'Write a comprehensive music wiki article about the artist/band \"test\".\n\nInclude these sections with markdown headers (##):\n## Early Life and Background\n- Origins, formation, early influences\n\n## Career\n- Career timeline, major releases, evolution\n\n## Musical Style\n- Genre, influences, signature sound, production style\n\n## Discography Highlights\n- Key albums and singles, collaborations\n\n## Awards and Recognition\n- Major awards, chart achievements, records\n\n## Legacy and Influence\n- Impact on music, influenced artists, cultural significance\n\n## Neural Connections\n- Provide a comma-separated list of 5-8 related concepts.\n- Explicitly include \"Archival Roles\" if known (e.g. Producer: [Name], Mastered By: [Name], Label: [Name], Remixed By: [Name]).\n\nWrite in an encyclopedic, neutral tone. Use facts where known, and be clear when speculating.', '## Early Life and Background\nThe artist/band \"test\" is a relatively unknown entity, with limited information available about their origins, formation, and early influences. It is speculated that \"test\" may be a pseudonym or a collective name for a group of musicians, but no concrete evidence has been found to support this claim. As a result, their early life and background remain shrouded in mystery.\n\n## Career\nThe career timeline of \"test\" is similarly unclear, with no notable releases or performances documented. It is possible that \"test\" is a conceptual or experimental project, with a focus on pushing the boundaries of sound and music. Without further information, it is difficult to pinpoint the exact evolution of their career or major releases.\n\n## Musical Style\nThe musical style of \"test\" is also unknown, as there are no available recordings or performances to analyze. It can be speculated that their genre may be experimental or avant-garde, given the lack of information and the enigmatic nature of the project. If \"test\" were to have a signature sound, it would likely be characterized by innovation and a willingness to challenge traditional musical conventions. The production style of \"test\" would likely be equally experimental, incorporating unconventional techniques and instrumentation.\n\n## Discography Highlights\nAs \"test\" has no documented discography, there are no key albums or singles to highlight. It is possible that they may have collaborated with other artists or producers, but without further information, these collaborations remain purely speculative.\n\n## Awards and Recognition\nGiven the lack of information about \"test\", it is unlikely that they have received any major awards or recognition. They may not have charted on any notable music charts, and it is unclear if they have set any records in the music industry.\n\n## Legacy and Influence\nThe legacy and influence of \"test\" are impossible to determine, as there is no concrete evidence of their existence or impact on the music world. It is possible that they may have influenced other artists or musicians, but without further information, this remains purely speculative. The cultural significance of \"test\" is also unknown, and it is unclear if they have contributed to any notable musical movements or trends.\n\n## Neural Connections\nExperimental music, avant-garde, electronic music, Producer: Unknown, Mastered By: Unknown, Label: Independent, Remixed By: Unknown, Archival Roles: Experimental composer, Sound designer, Music theorist.', 'completed', NULL, 2.89, '{\"topic\":\"test\",\"category\":\"artist\"}', '2026-02-12 06:18:25', '2026-02-12 06:18:25'),
(24, NULL, 'chat', 'ollama/llama3', 'What genres are trending right now?', '**Current Trending Genres:**\nSome of the most popular and trending music genres right now include:\n\n* **Hyperpop**: A fusion of pop, electronic, and experimental sounds, often featuring heavy use of distortion and auto-tune.\n* **Emo-Rap**: A subgenre of hip-hop that combines elements of emo and rap music, often focusing on emotional and personal lyrics.\n* **Afrobeats**: A genre originating from West Africa, characterized by its upbeat rhythms and blend of traditional and modern sounds.\n* **Latin Trap**: A subgenre of Latin music that combines elements of trap and reggaeton, often featuring heavy use of percussion and catchy melodies.\n* **Indie Folk**: A genre that emphasizes acoustic instrumentation and heartfelt, often poetic lyrics, with a focus on storytelling and atmospheric soundscapes.\n\nThese genres are not only popular among fans but also influencing the music industry as a whole. **Related Topics:** You might also be interested in exploring the rise of ** Drill Music** or the evolution of **Electronic Dance Music (EDM)**.', 'completed', NULL, 1.8536500930786, '{\"has_context\":false,\"history_count\":1}', '2026-02-13 10:03:12', '2026-02-13 10:03:12');

-- --------------------------------------------------------

--
-- Table structure for table `annotations`
--

CREATE TABLE `annotations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `article_id` bigint(20) UNSIGNED NOT NULL,
  `highlighted_text` text NOT NULL,
  `range_start` int(11) DEFAULT NULL,
  `range_end` int(11) DEFAULT NULL,
  `context_type` varchar(255) NOT NULL DEFAULT 'lyrics',
  `content` longtext NOT NULL,
  `votes` int(11) NOT NULL DEFAULT 0,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `is_master` tinyint(1) NOT NULL DEFAULT 0,
  `master_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `view_count` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `trending_score` decimal(10,2) NOT NULL DEFAULT 0.00,
  `seo_score` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `data_quality` tinyint(3) UNSIGNED NOT NULL DEFAULT 50,
  `trust_score` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `user_id`, `category`, `is_master`, `master_id`, `title`, `slug`, `content`, `excerpt`, `featured_image`, `view_count`, `trending_score`, `seo_score`, `status`, `data_quality`, `trust_score`, `published_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'genre', 0, NULL, 'Electronic', 'electronic', 'Music that employs electronic musical instruments.', NULL, NULL, 7, 2.74, 0, 'published', 50, 0, '2026-01-29 11:07:15', '2026-01-29 11:07:15', '2026-02-15 01:41:00', NULL),
(2, 1, 'genre', 0, NULL, 'House', 'house', 'Information about the genre House.', NULL, NULL, 1, 1.07, 0, 'published', 50, 0, '2026-01-29 11:07:15', '2026-01-29 11:07:15', '2026-02-16 16:01:01', NULL),
(3, 1, 'genre', 0, NULL, 'Deep House', 'deep-house', 'Information about the genre Deep House.', NULL, NULL, 2, 0.80, 0, 'published', 50, 0, '2026-01-29 11:07:15', '2026-01-29 11:07:15', '2026-02-16 15:59:31', NULL),
(4, 1, 'genre', 0, NULL, 'Tech House', 'tech-house', 'Information about the genre Tech House.', NULL, NULL, 2, 3.14, 0, 'published', 50, 0, '2026-01-29 11:07:15', '2026-01-29 11:07:15', '2026-02-08 12:48:48', NULL),
(5, 1, 'genre', 0, NULL, 'Techno', 'techno', 'Information about the genre Techno.', NULL, NULL, 1, 5.47, 0, 'published', 50, 0, '2026-01-29 11:07:15', '2026-01-29 11:07:15', '2026-01-30 02:48:12', NULL),
(6, 1, 'genre', 0, NULL, 'Rock', 'rock', 'Originating in the 1950s.', NULL, NULL, 1, 3.33, 0, 'published', 50, 0, '2026-01-29 11:07:15', '2026-01-29 11:07:15', '2026-02-12 06:25:47', NULL),
(7, 1, 'genre', 0, NULL, 'Alternative Rock', 'alternative-rock', 'Information about the genre Alternative Rock.', NULL, NULL, 2, 3.54, 0, 'published', 50, 0, '2026-01-29 11:07:16', '2026-01-29 11:07:16', '2026-02-12 05:42:48', NULL),
(8, 1, 'genre', 0, NULL, 'Grunge', 'grunge', 'Information about the genre Grunge.', NULL, NULL, 0, 0.00, 0, 'published', 50, 0, '2026-01-29 11:07:16', '2026-01-29 11:07:16', '2026-01-29 11:07:16', NULL),
(9, 1, 'genre', 0, NULL, 'Indie Rock', 'indie-rock', 'Information about the genre Indie Rock.', NULL, NULL, 1, 3.95, 0, 'published', 50, 0, '2026-01-29 11:07:16', '2026-01-29 11:07:16', '2026-02-12 05:50:28', NULL),
(10, 1, 'genre', 0, NULL, 'Metal', 'metal', 'Information about the genre Metal.', NULL, NULL, 3, 6.09, 0, 'published', 50, 0, '2026-01-29 11:07:16', '2026-01-29 11:07:16', '2026-02-08 07:42:29', NULL),
(11, 1, 'genre', 0, NULL, 'Hip Hop', 'hip-hop', 'Developed in the Bronx in the 1970s.', NULL, NULL, 3, 3.85, 0, 'published', 50, 0, '2026-01-29 11:07:16', '2026-01-29 11:07:16', '2026-02-12 06:51:22', NULL),
(12, 1, 'genre', 0, NULL, 'Old School', 'old-school', 'Information about the genre Old School.', NULL, NULL, 0, 0.00, 0, 'published', 50, 0, '2026-01-29 11:07:16', '2026-01-29 11:07:16', '2026-01-29 11:07:16', NULL),
(13, 1, 'genre', 0, NULL, 'Trap', 'trap', 'Information about the genre Trap.', NULL, NULL, 1, 2.18, 0, 'published', 50, 0, '2026-01-29 11:07:16', '2026-01-29 11:07:16', '2026-02-12 06:28:52', NULL),
(14, 1, 'artist', 0, NULL, 'Daft Punk', 'daft-punk', 'Biography of Daft Punk.', NULL, NULL, 12, 2.68, 0, 'published', 50, 0, '2026-01-29 11:07:16', '2026-01-29 11:07:16', '2026-02-16 16:20:41', NULL),
(15, 1, 'artist', 0, NULL, 'Pharrell Williams', 'pharrell-williams', 'Biography of Pharrell Williams.', NULL, NULL, 7, 2.61, 0, 'published', 50, 0, '2026-01-29 11:07:16', '2026-01-29 11:07:16', '2026-02-13 09:22:10', NULL),
(16, 1, 'artist', 0, NULL, 'Kanye West', 'kanye-west', 'Biography of Kanye West.', NULL, NULL, 4, 3.18, 0, 'published', 50, 0, '2026-01-29 11:07:16', '2026-01-29 11:07:16', '2026-02-13 15:16:23', NULL),
(17, 1, 'artist', 0, NULL, 'Nirvana', 'nirvana', 'Biography of Nirvana.', NULL, NULL, 22, 2.41, 0, 'published', 50, 0, '2026-01-29 11:07:16', '2026-01-29 11:07:16', '2026-02-16 16:00:04', NULL),
(18, 1, 'artist', 0, NULL, 'David Bowie', 'david-bowie', 'Biography of David Bowie.', NULL, NULL, 37, 4.11, 0, 'published', 50, 0, '2026-01-29 11:07:16', '2026-01-29 11:07:16', '2026-02-16 16:21:14', NULL),
(19, 1, 'artist', 0, NULL, 'Queen', 'queen', 'Biography of Queen.', NULL, NULL, 8, 6.56, 0, 'published', 50, 0, '2026-01-29 11:07:16', '2026-01-29 11:07:16', '2026-02-01 14:11:18', NULL),
(21, NULL, 'genre', 0, NULL, 'Jazz', 'jazz', 'Improvisational music with complex harmonies', NULL, NULL, 17032, 4.95, 0, 'published', 50, 0, NULL, '2026-01-30 17:56:43', '2026-02-13 04:14:43', NULL),
(22, NULL, 'genre', 0, NULL, 'Blues', 'blues', 'Soulful music with expressive vocals', NULL, NULL, 38226, 3.97, 0, 'published', 50, 0, NULL, '2026-01-30 17:56:43', '2026-02-13 09:57:12', NULL),
(23, NULL, 'genre', 0, NULL, 'Pop', 'pop', 'Mainstream popular music', NULL, NULL, 16383, 0.00, 0, 'published', 50, 0, NULL, '2026-01-30 17:56:43', '2026-01-30 17:56:43', NULL),
(24, NULL, 'genre', 0, NULL, 'Punk', 'punk', 'Fast, raw, and rebellious rock music', NULL, NULL, 48230, 4.20, 0, 'published', 50, 0, NULL, '2026-01-30 17:56:43', '2026-02-16 17:28:13', NULL),
(25, NULL, 'genre', 0, NULL, 'R&B', 'rnb', 'Rhythm and blues with soulful vocals', 'testing it', 'articles/0mbQH9MU3vYjoVZvAxlA1fP4f8zrxJBrVozj0Ark.png', 39701, 1.78, 0, 'published', 50, 0, NULL, '2026-01-30 17:56:43', '2026-02-16 16:00:39', NULL),
(26, NULL, 'genre', 0, NULL, 'Country', 'country', 'Folk-influenced American music', NULL, NULL, 2564, 0.00, 0, 'published', 50, 0, NULL, '2026-01-30 17:56:43', '2026-01-30 17:56:43', NULL),
(27, NULL, 'genre', 0, NULL, 'Reggae', 'reggae', 'Jamaican music with offbeat rhythms', NULL, NULL, 24832, 3.66, 0, 'published', 50, 0, NULL, '2026-01-30 17:56:43', '2026-02-13 09:26:06', NULL),
(28, NULL, 'genre', 0, NULL, 'Classical', 'classical', 'Traditional orchestral music', NULL, NULL, 27186, 1.31, 0, 'published', 50, 0, NULL, '2026-01-30 17:56:43', '2026-02-16 16:00:22', NULL),
(33, 1, 'term', 0, NULL, 'Reverb', 'reverb', 'Reverb is the persistence of sound after it is produced. It is created when a sound or signal is reflected causing numerous reflections to build up and then decay as the sound is absorbed by the surfaces of objects in the space.', NULL, NULL, 5, 4.84, 0, 'published', 50, 0, '2026-01-31 05:36:41', '2026-01-31 05:36:41', '2026-02-12 05:50:50', NULL),
(34, 1, 'term', 0, NULL, 'Syncopation', 'syncopation', 'In music, syncopation involves a variety of rhythms which are in some way unexpected, making part or all of a tune or piece of music off-beat.', NULL, NULL, 21, 5.52, 0, 'published', 50, 0, '2026-01-31 05:36:41', '2026-01-31 05:36:41', '2026-02-16 15:53:52', NULL),
(35, 1, 'playlist', 0, NULL, 'Ethereal Gloom', 'ethereal-gloom', 'A collection of haunting, atmospheric tracks that explore the intersection of dream pop and dark wave.', NULL, NULL, 21, 1.33, 0, 'published', 50, 0, '2026-01-31 05:36:41', '2026-01-31 05:36:41', '2026-02-16 16:21:24', NULL),
(36, 1, 'playlist', 0, NULL, 'Cyberpunk Protocol', 'cyberpunk-protocol', 'High-energy industrial techno and synthwave for high-stress simulation environments.', NULL, NULL, 29, 3.50, 0, 'published', 50, 0, '2026-01-31 05:36:41', '2026-01-31 05:36:41', '2026-02-13 09:48:22', NULL),
(37, NULL, 'song', 0, NULL, 'teststest', 'teststest', 'teswst dsf asdfa sdf adsfasdfasdf', '', 'articles/pwhGiC51QmdBblA6p74ps0h6iOuwoH2qj3g54KBr.webp', 36, 14.11, 0, 'published', 50, 0, '2026-02-08 08:16:54', '2026-02-08 08:16:54', '2026-02-13 09:47:55', NULL),
(38, NULL, 'genre', 0, NULL, 'test', 'test', 'tesa as tasdfasdf asdf asdfa dsf asdf', '', NULL, 15, 11.16, 0, 'published', 50, 0, '2026-02-08 11:54:36', '2026-02-08 11:54:36', '2026-02-11 02:43:32', NULL),
(39, 1, 'song', 0, NULL, 'Cola Bottle Baby', 'cola-bottle-baby', 'Classic funk track known for its iconic synth riff.', NULL, NULL, 14, 8.29, 0, 'published', 50, 0, NULL, '2026-02-13 04:23:15', '2026-02-16 17:28:28', NULL),
(40, 1, 'song', 0, NULL, 'Harder, Better, Faster, Stronger', 'hbfs', 'A standout track from Discovery.', NULL, NULL, 6, 4.57, 0, 'published', 50, 0, NULL, '2026-02-13 04:23:15', '2026-02-16 16:21:00', NULL),
(41, 1, 'song', 0, NULL, 'Stronger', 'stronger', 'Kanye West hits the mainstream with this Daft Punk sample.', NULL, NULL, 7, 3.59, 0, 'published', 50, 0, NULL, '2026-02-13 04:23:15', '2026-02-16 17:31:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `article_analyses`
--

CREATE TABLE `article_analyses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `article_id` bigint(20) UNSIGNED NOT NULL,
  `themes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`themes`)),
  `mood` varchar(255) DEFAULT NULL,
  `mood_score` int(11) DEFAULT NULL,
  `literary_devices` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`literary_devices`)),
  `rhyme_scheme` varchar(255) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `quality_score` int(11) DEFAULT NULL,
  `readability_score` int(11) DEFAULT NULL,
  `suggested_tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`suggested_tags`)),
  `related_articles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`related_articles`)),
  `analyzed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ambient_signature` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`ambient_signature`)),
  `emotional_resonance` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `article_analyses`
--

INSERT INTO `article_analyses` (`id`, `article_id`, `themes`, `mood`, `mood_score`, `literary_devices`, `rhyme_scheme`, `summary`, `quality_score`, `readability_score`, `suggested_tags`, `related_articles`, `analyzed_at`, `created_at`, `updated_at`, `ambient_signature`, `emotional_resonance`) VALUES
(1, 24, NULL, 'Atmospheric', 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-31 09:41:46', '2026-01-31 09:41:46', '2026-01-31 09:41:46', '{\"emotion\":\"Atmospheric\",\"energy\":7,\"gradient\":[\"#050510\",\"#0a0a2e\",\"#1e1e4a\",\"#3b82f6\"],\"themes\":[\"Artistic Resonance\",\"Emotional Depth\",\"Cultural Narrative\"],\"mood\":\"Captivating\",\"mood_score\":8,\"literary_devices\":[{\"type\":\"Metaphor\",\"example\":\"A mirror to the soul\",\"line\":1}],\"rhyme_scheme\":\"Articulate\",\"vocabulary_level\":\"Sophisticated\",\"summary\":\"A comprehensive analysis of the musical themes and lyrical depth.\",\"notable_lines\":[\"Echoes of the past\",\"Rhythms of a new dawn\"],\"genre_hints\":[\"Alternative\",\"Ambient\",\"Modern Fusion\"],\"primary_mood\":\"Atmospheric\",\"secondary_moods\":[\"Thoughtful\",\"Uplifting\"],\"intensity\":7,\"progression\":\"Subtle build to a thematic crescendo.\",\"emotional_keywords\":[\"Resilience\",\"Beauty\",\"Growth\"],\"terms\":[\"Compositional Detail\",\"Thematic Continuity\",\"Soundscape\"]}', NULL),
(2, 25, NULL, 'Atmospheric', 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-31 11:25:01', '2026-01-31 11:25:01', '2026-01-31 11:25:01', '{\"emotion\":\"Atmospheric\",\"energy\":7,\"gradient\":[\"#050510\",\"#0a0a2e\",\"#1e1e4a\",\"#3b82f6\"],\"themes\":[\"Artistic Resonance\",\"Emotional Depth\",\"Cultural Narrative\"],\"mood\":\"Captivating\",\"mood_score\":8,\"literary_devices\":[{\"type\":\"Metaphor\",\"example\":\"A mirror to the soul\",\"line\":1}],\"rhyme_scheme\":\"Articulate\",\"vocabulary_level\":\"Sophisticated\",\"summary\":\"A comprehensive analysis of the musical themes and lyrical depth.\",\"notable_lines\":[\"Echoes of the past\",\"Rhythms of a new dawn\"],\"genre_hints\":[\"Alternative\",\"Ambient\",\"Modern Fusion\"],\"primary_mood\":\"Atmospheric\",\"secondary_moods\":[\"Thoughtful\",\"Uplifting\"],\"intensity\":7,\"progression\":\"Subtle build to a thematic crescendo.\",\"emotional_keywords\":[\"Resilience\",\"Beauty\",\"Growth\"],\"terms\":[\"Compositional Detail\",\"Thematic Continuity\",\"Soundscape\"]}', NULL),
(3, 19, NULL, 'Regal', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-31 13:28:42', '2026-01-31 13:28:42', '2026-01-31 13:28:42', '{\"emotion\":\"Regal\",\"energy\":8,\"gradient\":[\"#8B0A1A\",\"#4B0082\",\"#6495ED\",\"#FFD700\"]}', NULL),
(4, 18, NULL, 'Ethereal', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-31 13:37:45', '2026-01-31 13:37:45', '2026-01-31 13:37:45', '{\"emotion\":\"Ethereal\",\"energy\":8,\"gradient\":[\"#660033\",\"#9900FF\",\"#CC33CC\",\"#FF66CC\"]}', NULL),
(5, 34, NULL, 'Ethereal', 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-31 13:38:24', '2026-01-31 13:38:24', '2026-01-31 13:38:24', '{\"emotion\":\"Ethereal\",\"energy\":6,\"gradient\":[\"#4567B7\",\"#6495ED\",\"#87CEEB\",\"#ADD8E6\"]}', NULL),
(6, 22, NULL, 'Ethereal', 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-01 14:08:39', '2026-02-01 14:08:39', '2026-02-01 14:08:39', '{\"emotion\":\"Ethereal\",\"energy\":6,\"gradient\":[\"#3B3F54\",\"#464E7A\",\"#5C7295\",\"#7889C4\"]}', NULL),
(7, 35, NULL, 'Melancholic', 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-01 14:09:07', '2026-02-01 14:09:07', '2026-02-01 14:09:07', '{\"emotion\":\"Melancholic\",\"energy\":6,\"gradient\":[\"#2E4053\",\"#1A1D23\",\"#0A0F14\",\"#663366\"]}', NULL),
(8, 10, NULL, 'Aggressive', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-01 14:19:50', '2026-02-01 14:19:50', '2026-02-01 14:19:50', '{\"emotion\":\"Aggressive\",\"energy\":8,\"gradient\":[\"#330033\",\"#440066\",\"#550099\",\"#6600CC\"]}', NULL),
(9, 11, NULL, 'Nostalgic', 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-01 14:20:06', '2026-02-01 14:20:06', '2026-02-01 14:20:06', '{\"emotion\":\"Nostalgic\",\"energy\":6,\"gradient\":[\"#786C3B\",\"#964B00\",\"#663300\",\"#FFC080\"]}', NULL),
(10, 36, NULL, 'Aggressive', 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-03 11:54:26', '2026-02-03 11:54:26', '2026-02-03 11:54:26', '{\"emotion\":\"Aggressive\",\"energy\":9,\"gradient\":[\"#8B0A1A\",\"#FF3737\",\"#FF9900\",\"#FFFF00\"]}', NULL),
(11, 17, NULL, 'Melancholic', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-03 12:02:19', '2026-02-03 12:02:19', '2026-02-03 12:02:19', '{\"emotion\":\"Melancholic\",\"energy\":\"8\",\"gradient\":[\"#333333\",\"#444444\",\"#555555\",\"#666666\"]}', NULL),
(12, 33, NULL, 'Ethereal', 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-03 12:27:09', '2026-02-03 12:27:09', '2026-02-03 12:27:09', '{\"emotion\":\"Ethereal\",\"energy\":6,\"gradient\":[\"#4567B7\",\"#6495ED\",\"#87CEEB\",\"#ADD8E6\"]}', NULL),
(13, 14, NULL, 'Ethereal', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-03 13:17:13', '2026-02-03 13:17:13', '2026-02-03 13:17:13', '{\"emotion\":\"Ethereal\",\"energy\":8,\"gradient\":[\"#3498DB\",\"#2ECC71\",\"#9B59B6\",\"#F1C40F\"]}', NULL),
(14, 16, NULL, 'Introspective', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-07 16:10:56', '2026-02-07 16:10:56', '2026-02-07 16:10:56', '{\"emotion\":\"Introspective\",\"energy\":8,\"gradient\":[\"#452B6A\",\"#6633CC\",\"#9944FF\",\"#FF66CC\"]}', NULL),
(15, 27, NULL, 'Euphoric', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-08 05:09:27', '2026-02-08 05:09:27', '2026-02-08 05:09:27', '{\"emotion\":\"Euphoric\",\"energy\":8,\"gradient\":[\"#34A853\",\"#FFD700\",\"#FFFF00\",\"#8BC34A\"]}', NULL),
(16, 37, NULL, 'Neutral', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-08 09:20:05', '2026-02-08 09:20:05', '2026-02-08 09:20:05', '{\"emotion\":\"Neutral\",\"energy\":\"1\",\"gradient\":[\"#777777\",\"#AAAAAA\",\"#CCCCCC\",\"#EEEEEE\"]}', NULL),
(17, 4, NULL, 'Atmospheric', 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-08 12:48:10', '2026-02-08 12:48:10', '2026-02-08 12:48:10', '{\"emotion\":\"Atmospheric\",\"energy\":7,\"gradient\":[\"#050510\",\"#0a0a2e\",\"#1e1e4a\",\"#3b82f6\"]}', NULL),
(18, 38, NULL, 'Ethereal', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-08 12:59:53', '2026-02-08 12:59:53', '2026-02-08 12:59:53', '{\"emotion\":\"Ethereal\",\"energy\":\"2\",\"gradient\":[\"#C9E4CA\",\"#87CEEB\",\"#6495ED\",\"#4567b7\"]}', NULL),
(19, 21, NULL, 'Ethereal', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-08 13:08:05', '2026-02-08 13:08:05', '2026-02-08 13:08:05', '{\"emotion\":\"Ethereal\",\"energy\":\"8\",\"gradient\":[\"#4567B7\",\"#6495ED\",\"#87CEEB\",\"#ADD8E6\"]}', NULL),
(20, 15, NULL, 'Euphoric', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-11 02:31:30', '2026-02-11 02:31:30', '2026-02-11 02:31:30', '{\"emotion\":\"Euphoric\",\"energy\":\"8\",\"gradient\":[\"#8BC34A\",\"#64DD17\",\"#34C759\",\"#FFD700\"]}', NULL),
(21, 7, NULL, 'Ethereal', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-12 04:14:34', '2026-02-12 04:14:34', '2026-02-12 04:14:34', '{\"emotion\":\"Ethereal\",\"energy\":8,\"gradient\":[\"#662D91\",\"#6633CC\",\"#66CCCC\",\"#66FF99\"]}', NULL),
(22, 9, NULL, 'Ethereal', 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-12 05:50:28', '2026-02-12 05:50:28', '2026-02-12 05:50:28', '{\"emotion\":\"Ethereal\",\"energy\":7,\"gradient\":[\"#8B9467\",\"#6495ED\",\"#2F4F7F\",\"#663300\"]}', NULL),
(23, 6, NULL, 'Nostalgic', 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-12 06:25:46', '2026-02-12 06:25:46', '2026-02-12 06:25:46', '{\"emotion\":\"Nostalgic\",\"energy\":\"6\",\"gradient\":[\"#8B9467\",\"#C9C4B5\",\"#F7F7F7\",\"#948C69\"]}', NULL),
(24, 13, NULL, 'Atmospheric', 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-12 06:28:52', '2026-02-12 06:28:52', '2026-02-12 06:28:52', '{\"emotion\":\"Atmospheric\",\"energy\":7,\"gradient\":[\"#050510\",\"#0a0a2e\",\"#1e1e4a\",\"#3b82f6\"]}', NULL),
(25, 39, NULL, 'Euphoric', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-13 04:41:06', '2026-02-13 04:41:06', '2026-02-13 04:41:06', '{\"emotion\":\"Euphoric\",\"energy\":\"8\",\"gradient\":[\"#FFC107\",\"#FFA07A\",\"#FFFF00\",\"#8BC34A\"]}', NULL),
(26, 1, NULL, 'Ethereal', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-13 06:53:43', '2026-02-13 06:53:43', '2026-02-13 06:53:43', '{\"emotion\":\"Ethereal\",\"energy\":8,\"gradient\":[\"#2E4053\",\"#1A1D23\",\"#0A043C\",\"#66CCFF\"]}', NULL),
(27, 40, NULL, 'Ethereal', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-13 09:13:30', '2026-02-13 09:13:30', '2026-02-13 09:13:30', '{\"emotion\":\"Ethereal\",\"energy\":\"8\",\"gradient\":[\"#56B3FA\",\"#45A0E6\",\"#2F80ED\",\"#1A45DD\"]}', NULL),
(28, 28, NULL, 'Ethereal', 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-13 09:36:08', '2026-02-13 09:36:08', '2026-02-13 09:36:08', '{\"emotion\":\"Ethereal\",\"energy\":\"6\",\"gradient\":[\"#456778\",\"#6495ED\",\"#87CEEB\",\"#ACC9F2\"]}', NULL),
(29, 41, NULL, 'Euphoric', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-13 12:25:45', '2026-02-13 12:25:45', '2026-02-13 12:25:45', '{\"emotion\":\"Euphoric\",\"energy\":8,\"gradient\":[\"#8E44AD\",\"#6c5ce7\",\"#3485e6\",\"#66d9ef\"]}', NULL),
(30, 3, NULL, 'Ethereal', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-16 15:54:26', '2026-02-16 15:54:26', '2026-02-16 15:54:26', '{\"emotion\":\"Ethereal\",\"energy\":\"8\",\"gradient\":[\"#2E4053\",\"#1A1D23\",\"#3498DB\",\"#66D9EF\"]}', NULL),
(31, 2, NULL, 'Euphoric', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-16 16:01:01', '2026-02-16 16:01:01', '2026-02-16 16:01:01', '{\"emotion\":\"Euphoric\",\"energy\":8,\"gradient\":[\"#3498DB\",\"#2ECC71\",\"#1ABC9C\",\"#F1C40F\"]}', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `article_gear`
--

CREATE TABLE `article_gear` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `article_id` bigint(20) UNSIGNED NOT NULL,
  `gear_id` bigint(20) UNSIGNED NOT NULL,
  `usage_notes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `article_relationships`
--

CREATE TABLE `article_relationships` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `source_id` bigint(20) UNSIGNED NOT NULL,
  `target_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `strength` int(11) NOT NULL DEFAULT 50,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `article_relationships`
--

INSERT INTO `article_relationships` (`id`, `source_id`, `target_id`, `type`, `strength`, `metadata`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'influence', 50, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(2, 1, 4, 'related', 30, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(3, 2, 3, 'influence', 50, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(4, 2, 5, 'related', 30, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(5, 3, 4, 'influence', 50, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(6, 3, 6, 'related', 30, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(7, 4, 5, 'influence', 50, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(8, 4, 7, 'related', 30, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(9, 5, 6, 'influence', 50, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(10, 5, 8, 'related', 30, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(11, 6, 7, 'influence', 50, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(12, 6, 9, 'related', 30, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(13, 7, 8, 'influence', 50, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(14, 7, 10, 'related', 30, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(15, 8, 9, 'influence', 50, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(16, 8, 11, 'related', 30, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(17, 9, 10, 'influence', 50, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(18, 9, 12, 'related', 30, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(19, 10, 11, 'influence', 50, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(20, 10, 13, 'related', 30, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(21, 11, 12, 'influence', 50, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(22, 11, 14, 'related', 30, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(23, 12, 13, 'influence', 50, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(24, 12, 15, 'related', 30, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(25, 13, 14, 'influence', 50, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(26, 13, 16, 'related', 30, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(27, 14, 15, 'influence', 50, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(28, 14, 17, 'related', 30, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(29, 15, 16, 'influence', 50, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(30, 15, 18, 'related', 30, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(31, 16, 17, 'influence', 50, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(32, 16, 19, 'related', 30, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(33, 17, 18, 'influence', 50, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(34, 17, 21, 'related', 30, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(35, 18, 19, 'influence', 50, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(36, 19, 21, 'influence', 50, NULL, '2026-02-11 11:10:31', '2026-02-11 11:10:31'),
(37, 40, 39, 'samples', 50, '{\"timestamp\":\"0:00\"}', '2026-02-13 04:24:26', '2026-02-13 04:24:26'),
(38, 41, 40, 'samples', 50, '{\"timestamp\":\"0:00\"}', '2026-02-13 04:24:26', '2026-02-13 04:24:26');

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `article_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `spotify_id` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `social_links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`social_links`)),
  `active_from` date DEFAULT NULL,
  `active_to` date DEFAULT NULL,
  `origin_location` varchar(255) DEFAULT NULL,
  `active_years_string` varchar(255) DEFAULT NULL,
  `top_songs_meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`top_songs_meta`)),
  `breakthrough_moment` text DEFAULT NULL,
  `live_performances` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `article_id`, `name`, `spotify_id`, `website`, `social_links`, `active_from`, `active_to`, `origin_location`, `active_years_string`, `top_songs_meta`, `breakthrough_moment`, `live_performances`, `created_at`, `updated_at`, `latitude`, `longitude`) VALUES
(1, 14, 'Daft Punk', NULL, NULL, NULL, '2006-01-29', NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-29 11:07:16', '2026-02-16 14:51:37', 48.85600000, 2.35200000),
(2, 15, 'Pharrell Williams', NULL, NULL, NULL, '2006-01-29', NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-29 11:07:16', '2026-01-29 11:07:16', NULL, NULL),
(3, 16, 'Kanye West', NULL, NULL, NULL, '2006-01-29', NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-29 11:07:16', '2026-01-29 11:07:16', NULL, NULL),
(4, 17, 'Nirvana', NULL, NULL, NULL, '2006-01-29', NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-29 11:07:16', '2026-01-29 11:07:16', NULL, NULL),
(5, 18, 'David Bowie', NULL, NULL, NULL, '2006-01-29', NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-29 11:07:16', '2026-01-29 11:07:16', NULL, NULL),
(6, 19, 'Queen', NULL, NULL, NULL, '2006-01-29', NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-29 11:07:16', '2026-01-29 11:07:16', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `artist_collaborations`
--

CREATE TABLE `artist_collaborations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `artist1_id` bigint(20) UNSIGNED NOT NULL,
  `artist2_id` bigint(20) UNSIGNED NOT NULL,
  `collaboration_type` varchar(255) NOT NULL,
  `work_title` varchar(255) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `artist_collaborations`
--

INSERT INTO `artist_collaborations` (`id`, `artist1_id`, `artist2_id`, `collaboration_type`, `work_title`, `year`, `created_at`, `updated_at`) VALUES
(1, 14, 15, 'feature', 'Get Lucky', 2013, '2026-01-29 11:07:16', '2026-01-29 11:07:16'),
(2, 16, 14, 'sample', 'Stronger', 2007, '2026-01-29 11:07:16', '2026-01-29 11:07:16');

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

CREATE TABLE `bookmarks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `article_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('chaynwiki-cache-admin@kentro.is|127.0.0.1', 'i:1;', 1771234454),
('chaynwiki-cache-admin@kentro.is|127.0.0.1:timer', 'i:1771234454;', 1771234454),
('chaynwiki-cache-yaservu@gmail.com|127.0.0.1', 'i:1;', 1771272264),
('chaynwiki-cache-yaservu@gmail.com|127.0.0.1:timer', 'i:1771272264;', 1771272264);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `article_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `content` text NOT NULL,
  `upvotes` int(11) NOT NULL DEFAULT 0,
  `downvotes` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crate_articles`
--

CREATE TABLE `crate_articles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `crate_id` bigint(20) UNSIGNED NOT NULL,
  `article_id` bigint(20) UNSIGNED NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `crate_articles`
--

INSERT INTO `crate_articles` (`id`, `crate_id`, `article_id`, `notes`, `created_at`, `updated_at`) VALUES
(2, 2, 1, NULL, '2026-02-11 11:13:56', '2026-02-11 11:13:56'),
(3, 2, 2, NULL, '2026-02-11 11:13:56', '2026-02-11 11:13:56'),
(4, 2, 3, NULL, '2026-02-11 11:13:56', '2026-02-11 11:13:56');

-- --------------------------------------------------------

--
-- Table structure for table `crate_collaborators`
--

CREATE TABLE `crate_collaborators` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `crate_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'contributor',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `followable_type` varchar(255) NOT NULL,
  `followable_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gears`
--

CREATE TABLE `gears` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `type` enum('instrument','hardware','software','daw','accessory') NOT NULL DEFAULT 'hardware',
  `brand` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gears`
--

INSERT INTO `gears` (`id`, `name`, `slug`, `type`, `brand`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Minimoog Model D', 'minimoog-model-d', 'hardware', 'Moog', 'The world’s first portable synthesizer and the archetype for all later electronic keyboards. Known for its thick, fat analog bass and lead sounds.', 'https://images.unsplash.com/photo-1598653222000-6b7b7a552625?w=500&q=80', '2026-02-16 14:38:50', '2026-02-16 14:38:50'),
(2, 'Prophet-5', 'prophet-5', 'hardware', 'Sequential Circuits', 'A legendary polyphonic analog synthesizer used extensively in the 1980s by artists like Michael Jackson and Radiohead.', 'https://images.unsplash.com/photo-1614113400622-c3230005d528?w=500&q=80', '2026-02-16 14:38:50', '2026-02-16 14:38:50'),
(3, 'DX7', 'dx7', 'hardware', 'Yamaha', 'The digital synthesizer that defined the sound of 80s pop music with its FM synthesis, famous for its electric piano and bell sounds.', 'https://images.unsplash.com/photo-1542646274-725838446261?w=500&q=80', '2026-02-16 14:38:50', '2026-02-16 14:38:50'),
(4, 'TR-808', 'tr-808', 'hardware', 'Roland', 'The most famous drum machine of all time. Its booming kick drum forms the foundation of Hip Hop, Techno, and Trap music.', 'https://images.unsplash.com/photo-1519508234439-4f23643125c1?w=500&q=80', '2026-02-16 14:38:50', '2026-02-16 14:38:50'),
(5, 'TR-909', 'tr-909', 'hardware', 'Roland', 'A hybrid analog/digital drum machine crucial for the development of House and Techno music.', 'https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?w=500&q=80', '2026-02-16 14:38:50', '2026-02-16 14:38:50'),
(6, 'MPC 3000', 'mpc-3000', 'hardware', 'Akai', 'The sampler and sequencer that defined the swing and rhythm of 90s Hip Hop, used by J Dilla and Dr. Dre.', 'https://images.unsplash.com/photo-1516280440614-6697288d5d38?w=500&q=80', '2026-02-16 14:38:50', '2026-02-16 14:38:50'),
(7, 'Stratocaster', 'stratocaster', 'instrument', 'Fender', 'An iconic electric guitar known for its bright, articulate sound. Used by Jimi Hendrix, David Gilmour, and countless others.', 'https://images.unsplash.com/photo-1550985543-f4423c8d2991?w=500&q=80', '2026-02-16 14:38:50', '2026-02-16 14:38:50'),
(8, 'Les Paul Standard', 'les-paul-standard', 'instrument', 'Gibson', 'Famous for its thick, warm, and sustaining tone, a staple of Rock and Blues music.', 'https://images.unsplash.com/photo-1564186763531-6418a265b3d9?w=500&q=80', '2026-02-16 14:38:50', '2026-02-16 14:38:50'),
(9, 'Precision Bass', 'precision-bass', 'instrument', 'Fender', 'The first mass-produced electric bass guitar, providing the low-end thump for Motown, Rock, and Punk.', 'https://images.unsplash.com/photo-1627926296766-c67d84877395?w=500&q=80', '2026-02-16 14:38:50', '2026-02-16 14:38:50'),
(10, 'Ableton Live', 'ableton-live', 'daw', 'Ableton', 'A unique digital audio workstation designed for live performance and intuitive loop-based composition.', 'https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?w=500&q=80', '2026-02-16 14:38:50', '2026-02-16 14:38:50'),
(11, 'Pro Tools', 'pro-tools', 'daw', 'Avid', 'The industry standard DAW for professional recording studios and post-production facilities.', 'https://images.unsplash.com/photo-1598653222000-6b7b7a552625?w=500&q=80', '2026-02-16 14:38:50', '2026-02-16 14:38:50'),
(12, 'Auto-Tune', 'auto-tune', 'software', 'Antares', 'Pitch correction software that changed the sound of modern vocal production, often used as a creative effect.', 'https://images.unsplash.com/photo-1516280440614-6697288d5d38?w=500&q=80', '2026-02-16 14:38:50', '2026-02-16 14:38:50'),
(13, 'U87', 'u87', 'hardware', 'Neumann', 'The most widely used large-diaphragm condenser microphone in professional studios for vocals.', 'https://images.unsplash.com/photo-1590845947391-ba13a6647b31?w=500&q=80', '2026-02-16 14:38:50', '2026-02-16 14:38:50'),
(14, 'SM7B', 'sm7b', 'hardware', 'Shure', 'A dynamic broadcast microphone famously used by Michael Jackson on \"Thriller\" and now a standard for podcasts.', 'https://images.unsplash.com/photo-1525438885566-22485e98585e?w=500&q=80', '2026-02-16 14:38:50', '2026-02-16 14:38:50');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `article_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '#3B82F6',
  `era_start` int(11) DEFAULT NULL,
  `era_end` int(11) DEFAULT NULL,
  `popularity_score` int(11) NOT NULL DEFAULT 0,
  `parent_genre_id` bigint(20) UNSIGNED DEFAULT NULL,
  `creator` varchar(255) DEFAULT NULL,
  `origin_date` varchar(255) DEFAULT NULL,
  `origin_country` varchar(255) DEFAULT NULL,
  `appearance_year` varchar(255) DEFAULT NULL,
  `popular_artists` text DEFAULT NULL,
  `early_history` text DEFAULT NULL,
  `cultural_impact` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `article_id`, `name`, `slug`, `description`, `color`, `era_start`, `era_end`, `popularity_score`, `parent_genre_id`, `creator`, `origin_date`, `origin_country`, `appearance_year`, `popular_artists`, `early_history`, `cultural_impact`, `created_at`, `updated_at`) VALUES
(1, 6, 'Rock', 'rock', 'Electric guitar-driven music with strong rhythms', '#EF4444', 1950, NULL, 95, NULL, NULL, '1950', NULL, NULL, NULL, NULL, NULL, '2026-01-31 05:33:45', '2026-01-31 05:33:45'),
(2, 21, 'Jazz', 'jazz', 'Improvisational music with complex harmonies', '#F59E0B', 1920, NULL, 85, NULL, NULL, '1920', NULL, NULL, NULL, NULL, NULL, '2026-01-31 05:33:45', '2026-01-31 05:33:45'),
(3, 22, 'Blues', 'blues', 'Soulful music with expressive vocals', '#3B82F6', 1890, NULL, 75, NULL, NULL, '1890', NULL, NULL, NULL, NULL, NULL, '2026-01-31 05:33:45', '2026-01-31 05:33:45'),
(4, 11, 'Hip Hop', 'hip-hop', 'Rhythmic music with rapping and beats', '#8B5CF6', 1970, NULL, 98, NULL, NULL, '1970', NULL, NULL, NULL, NULL, NULL, '2026-01-31 05:33:45', '2026-01-31 05:33:45'),
(5, 1, 'Electronic', 'electronic', 'Synthesizer and computer-based music', '#06B6D4', 1980, NULL, 92, NULL, NULL, '1980', NULL, NULL, NULL, NULL, NULL, '2026-01-31 05:33:45', '2026-01-31 05:33:45'),
(6, 23, 'Pop', 'pop', 'Mainstream popular music', '#EC4899', 1960, NULL, 100, NULL, NULL, '1960', NULL, NULL, NULL, NULL, NULL, '2026-01-31 05:33:45', '2026-01-31 05:33:45'),
(7, 10, 'Metal', 'metal', 'Heavy distorted guitars and aggressive vocals', '#DC2626', 1970, NULL, 88, NULL, NULL, '1970', NULL, NULL, NULL, NULL, NULL, '2026-01-31 05:33:45', '2026-01-31 05:33:45'),
(8, 24, 'Punk', 'punk', 'Fast, raw, and rebellious rock music', '#F97316', 1974, NULL, 78, NULL, NULL, '1974', NULL, NULL, NULL, NULL, NULL, '2026-01-31 05:33:45', '2026-01-31 05:33:45'),
(9, 25, 'R&B', 'rnb', 'Rhythm and blues with soulful vocals', '#A855F7', 1940, NULL, 90, NULL, NULL, '1940', NULL, NULL, NULL, NULL, NULL, '2026-01-31 05:33:45', '2026-01-31 05:33:45'),
(10, 26, 'Country', 'country', 'Folk-influenced American music', '#84CC16', 1920, NULL, 82, NULL, NULL, '1920', NULL, NULL, NULL, NULL, NULL, '2026-01-31 05:33:45', '2026-01-31 05:33:45'),
(11, 27, 'Reggae', 'reggae', 'Jamaican music with offbeat rhythms', '#10B981', 1968, NULL, 80, NULL, NULL, '1968', NULL, NULL, NULL, NULL, NULL, '2026-01-31 05:33:45', '2026-01-31 05:33:45'),
(12, 28, 'Classical', 'classical', 'Traditional orchestral music', '#6366F1', 1750, 1820, 70, NULL, NULL, '1750', NULL, NULL, NULL, NULL, NULL, '2026-01-31 05:33:45', '2026-01-31 05:33:45'),
(13, 38, 'test', NULL, NULL, '#3B82F6', NULL, NULL, 0, NULL, NULL, NULL, 'test', 'fasdfassdf', 'fasdfas', 'test', 'stest', '2026-02-08 11:54:36', '2026-02-08 11:54:36');

-- --------------------------------------------------------

--
-- Table structure for table `genre_relationships`
--

CREATE TABLE `genre_relationships` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `source_genre_id` bigint(20) UNSIGNED NOT NULL,
  `target_genre_id` bigint(20) UNSIGNED NOT NULL,
  `relationship_type` varchar(255) NOT NULL,
  `strength` int(11) NOT NULL DEFAULT 50,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `genre_relationships`
--

INSERT INTO `genre_relationships` (`id`, `source_genre_id`, `target_genre_id`, `relationship_type`, `strength`, `description`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'influences', 90, NULL, '2026-01-31 05:33:45', '2026-01-31 05:33:45'),
(2, 1, 7, 'influences', 85, NULL, '2026-01-31 05:33:45', '2026-01-31 05:33:45'),
(3, 1, 8, 'influences', 80, NULL, '2026-01-31 05:33:45', '2026-01-31 05:33:45'),
(4, 3, 2, 'influences', 75, NULL, '2026-01-31 05:33:45', '2026-01-31 05:33:45'),
(5, 2, 4, 'influences', 60, NULL, '2026-01-31 05:33:45', '2026-01-31 05:33:45'),
(6, 5, 4, 'fusion_of', 70, NULL, '2026-01-31 05:33:45', '2026-01-31 05:33:45'),
(7, 6, 5, 'fusion_of', 65, NULL, '2026-01-31 05:33:45', '2026-01-31 05:33:45'),
(8, 3, 9, 'influences', 85, NULL, '2026-01-31 05:33:45', '2026-01-31 05:33:45'),
(9, 9, 4, 'influences', 90, NULL, '2026-01-31 05:33:45', '2026-01-31 05:33:45'),
(10, 9, 6, 'influences', 75, NULL, '2026-01-31 05:33:45', '2026-01-31 05:33:45'),
(11, 9, 11, 'influences', 60, NULL, '2026-01-31 05:33:45', '2026-01-31 05:33:45'),
(12, 11, 4, 'influences', 55, NULL, '2026-01-31 05:33:45', '2026-01-31 05:33:45');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `knowledge_graph_links`
--

CREATE TABLE `knowledge_graph_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `source_id` bigint(20) UNSIGNED NOT NULL,
  `target_id` bigint(20) UNSIGNED NOT NULL,
  `weight` double NOT NULL DEFAULT 1,
  `type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `knowledge_wantlist`
--

CREATE TABLE `knowledge_wantlist` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `votes` int(11) NOT NULL DEFAULT 1,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_25_105636_create_articles_table', 1),
(5, '2026_01_25_105637_create_artists_table', 1),
(6, '2026_01_25_105638_create_genres_table', 1),
(7, '2026_01_25_105639_create_songs_table', 1),
(8, '2026_01_25_105640_create_playlists_table', 1),
(9, '2026_01_25_105641_add_chayn_fields_to_users_table', 1),
(10, '2026_01_25_105641_create_wiki_interactions_tables', 1),
(11, '2026_01_25_111110_add_username_to_users_table', 2),
(12, '2026_01_25_194521_create_votes_table', 3),
(13, '2026_01_28_170447_add_status_to_revisions_table', 4),
(14, '2026_01_28_172606_add_is_featured_to_articles_table', 5),
(15, '2026_01_29_093751_create_ai_generations_table', 6),
(16, '2026_01_29_093820_create_user_achievements_table', 6),
(17, '2026_01_29_093843_create_search_logs_table', 6),
(18, '2026_01_29_122032_create_genre_relationships_table', 7),
(19, '2026_01_29_124500_add_performance_indexes', 8),
(20, '2026_01_29_125000_add_views_to_articles', 9),
(21, '2026_01_29_130000_drop_views_column', 10),
(22, '2026_01_29_183500_add_explorer_fields_to_genres_table', 11),
(23, '2026_01_30_071256_add_status_to_revisions_table', 12),
(24, '2026_01_30_231708_add_new_figma_fields_to_content_tables', 13),
(25, '2026_01_31_103107_create_terms_table', 14),
(26, '2026_01_31_103509_add_spotify_fields_to_playlists_table', 15),
(27, '2026_01_31_140948_create_user_crates_table', 16),
(28, '2026_01_31_142457_create_crate_articles_table', 16),
(31, '2026_01_31_142649_add_ambient_signature_to_article_analyses_table', 17),
(32, '2026_02_11_113000_add_spotify_fields_to_users_table', 18),
(33, '2026_02_11_155210_create_crate_social_extensions_table', 19),
(34, '2026_02_11_153158_create_article_relationships_table', 20),
(35, '2026_02_12_150000_create_knowledge_graph_links_table', 21),
(36, '2026_02_12_160500_add_discogs_structural_fields', 22),
(38, '2026_02_13_180409_add_score_to_votes_table', 23),
(39, '2026_02_13_180836_create_annotatable_table', 24),
(41, '2026_02_16_193318_create_gears_table', 25),
(42, '2026_02_16_194032_add_camelot_key_to_songs_table', 26),
(43, '2026_02_16_194518_add_coordinates_to_artists_table', 27);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `playlists`
--

CREATE TABLE `playlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `article_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `curator` varchar(255) DEFAULT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `platform_link` varchar(255) DEFAULT NULL,
  `spotify_id` varchar(255) DEFAULT NULL,
  `curator_note` text DEFAULT NULL,
  `track_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `playlists`
--

INSERT INTO `playlists` (`id`, `article_id`, `title`, `curator`, `platform`, `platform_link`, `spotify_id`, `curator_note`, `track_count`, `created_at`, `updated_at`) VALUES
(1, 35, 'Ethereal Gloom', NULL, NULL, NULL, '37i9dQZF1DXdbX4vYI9p06', 'Best enjoyed at 3 AM with headphones. Focuses on spatial clarity.', 45, '2026-01-31 05:36:41', '2026-01-31 05:36:41'),
(2, 36, 'Cyberpunk Protocol', NULL, NULL, NULL, '37i9dQZF1DX6as9Y99u9Yv', 'Optimized for high-speed focus and aggressive productivity.', 32, '2026-01-31 05:36:41', '2026-01-31 05:36:41');

-- --------------------------------------------------------

--
-- Table structure for table `playlist_tracks`
--

CREATE TABLE `playlist_tracks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `playlist_id` bigint(20) UNSIGNED NOT NULL,
  `song_id` bigint(20) UNSIGNED DEFAULT NULL,
  `position` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `revisions`
--

CREATE TABLE `revisions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `article_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `content_snapshot` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`content_snapshot`)),
  `change_summary` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'approved',
  `moderated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `moderated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `revisions`
--

INSERT INTO `revisions` (`id`, `article_id`, `user_id`, `content_snapshot`, `change_summary`, `created_at`, `updated_at`, `status`, `moderated_by`, `moderated_at`) VALUES
(1, 13, NULL, '{\"user_id\":13,\"category\":\"genre\",\"title\":\"test\",\"slug\":\"test\",\"content\":\"<p>test<\\/p>\",\"excerpt\":\"\",\"featured_image\":null,\"status\":\"published\",\"published_at\":\"2026-01-26T18:43:36.000000Z\",\"updated_at\":\"2026-01-26T18:43:36.000000Z\",\"created_at\":\"2026-01-26T18:43:36.000000Z\",\"id\":13}', 'Initial creation', '2026-01-26 13:43:36', '2026-01-26 13:43:36', 'approved', NULL, NULL),
(2, 25, NULL, '{\"category\":\"genre\",\"title\":\"R&B\",\"content\":\"Rhythm and blues with soulful vocals\",\"excerpt\":\"testing it\"}', 'nothing...', '2026-01-31 12:31:24', '2026-01-31 12:39:20', 'approved', 1, '2026-01-31 12:39:20'),
(3, 25, 1, '{\"category\":\"genre\",\"title\":\"R&B\",\"content\":\"Rhythm and blues with soulful vocals\",\"excerpt\":\"testing it\",\"featured_image\":\"articles\\/0mbQH9MU3vYjoVZvAxlA1fP4f8zrxJBrVozj0Ark.png\"}', 'hello', '2026-01-31 12:42:17', '2026-01-31 12:42:17', 'approved', NULL, NULL),
(4, 37, NULL, '{\"title\":\"teststest\",\"category\":\"song\",\"content\":\"teswst dsf asdfa sdf adsfasdfasdf\",\"excerpt\":\"\",\"featured_image\":\"\\/storage\\/articles\\/pwhGiC51QmdBblA6p74ps0h6iOuwoH2qj3g54KBr.webp\",\"artist_name\":\"test\",\"release_date\":\"3434\",\"genre\":\"test\",\"songwriters\":\"test\",\"studio_recorded\":\"test\",\"behind_the_song\":\"stest\",\"achievements\":\"stest\",\"lyrics_snippet\":\"test\"}', 'Initial creation', '2026-02-08 08:16:54', '2026-02-08 08:16:54', 'approved', NULL, NULL),
(5, 38, NULL, '{\"title\":\"test\",\"category\":\"genre\",\"content\":\"tesa as tasdfasdf asdf asdfa dsf asdf\",\"excerpt\":\"\",\"featured_image\":\"https:\\/\\/images.unsplash.com\\/photo-1514525253361-bee8a48740ad?w=800&q=80\",\"artist_name\":\"test\",\"active_years\":\"test\",\"origin_country\":\"test\",\"genre\":\"fasdfassdf\",\"appearance_year\":\"fasdfassdf\",\"top_songs\":\"fasdfas\",\"popular_artists\":\"fasdfas\",\"subgenres\":\"test\",\"breakthrough_moment\":\"test\",\"early_history\":\"test\",\"behind_the_song\":\"stest\",\"live_performances\":\"stest\",\"cultural_impact\":\"stest\"}', 'Initial creation', '2026-02-08 11:54:36', '2026-02-08 11:54:36', 'approved', NULL, NULL),
(6, 37, NULL, '{\"category\":\"song\",\"title\":\"teststest\",\"content\":\"teswst dsf asdfa sdf adsfasdfasdf\",\"excerpt\":\"\"}', 'ddddd', '2026-02-08 12:04:56', '2026-02-08 12:04:56', 'pending', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `search_logs`
--

CREATE TABLE `search_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `query` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `results_count` int(11) NOT NULL DEFAULT 0,
  `clicked_article_id` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `search_logs`
--

INSERT INTO `search_logs` (`id`, `user_id`, `query`, `category`, `results_count`, `clicked_article_id`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, NULL, 'tiktok', NULL, 0, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-30 09:03:52', '2026-01-30 09:03:52'),
(2, NULL, 'test', NULL, 0, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-04 04:29:11', '2026-02-04 04:29:11'),
(3, NULL, 'test', NULL, 0, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-04 04:33:35', '2026-02-04 04:33:35'),
(4, NULL, 'test', NULL, 0, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-04 04:44:49', '2026-02-04 04:44:49'),
(5, NULL, 'how', NULL, 0, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-04 04:45:12', '2026-02-04 04:45:12'),
(6, NULL, 'how', NULL, 0, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-04 04:46:32', '2026-02-04 04:46:32'),
(7, NULL, 'test', NULL, 0, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-04 04:56:19', '2026-02-04 04:56:19'),
(8, NULL, 'test', NULL, 0, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-04 05:02:38', '2026-02-04 05:02:38'),
(9, NULL, 'test', NULL, 0, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 12:48:17', '2026-02-08 12:48:17'),
(10, NULL, 'tes', NULL, 0, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 12:53:18', '2026-02-08 12:53:18'),
(11, NULL, 'tes', NULL, 0, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 12:54:38', '2026-02-08 12:54:38'),
(12, NULL, 'test', NULL, 0, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 12:58:02', '2026-02-08 12:58:02'),
(13, NULL, 'test', NULL, 0, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 12:58:08', '2026-02-08 12:58:08'),
(14, NULL, 'test', NULL, 0, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 12:58:10', '2026-02-08 12:58:10'),
(15, NULL, 'test', NULL, 0, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 12:59:01', '2026-02-08 12:59:01'),
(16, NULL, 'test', NULL, 0, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 12:59:34', '2026-02-08 12:59:34'),
(17, NULL, 'test', NULL, 0, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 12:59:57', '2026-02-08 12:59:57'),
(18, NULL, 'test', NULL, 0, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 13:00:28', '2026-02-08 13:00:28'),
(19, NULL, 'test', NULL, 0, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 13:01:20', '2026-02-08 13:01:20'),
(20, NULL, 'test', NULL, 0, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 13:01:57', '2026-02-08 13:01:57'),
(21, NULL, 'test', NULL, 0, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 13:01:59', '2026-02-08 13:01:59'),
(22, NULL, 'test', NULL, 0, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 13:02:04', '2026-02-08 13:02:04'),
(23, NULL, 'test', NULL, 0, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 13:02:06', '2026-02-08 13:02:06'),
(24, NULL, 'test', NULL, 0, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 13:02:09', '2026-02-08 13:02:09'),
(25, NULL, 'test', NULL, 0, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 13:02:11', '2026-02-08 13:02:11'),
(26, NULL, 'test', NULL, 0, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 13:02:15', '2026-02-08 13:02:15'),
(27, NULL, 'test', NULL, 0, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 13:02:42', '2026-02-08 13:02:42'),
(28, NULL, 'test', NULL, 0, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-10 15:39:18', '2026-02-10 15:39:18'),
(29, NULL, 'test', 'song', 0, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-10 15:39:23', '2026-02-10 15:39:23'),
(30, NULL, 'he', NULL, 0, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 04:51:37', '2026-02-12 04:51:37'),
(31, NULL, 'he', NULL, 0, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 04:52:29', '2026-02-12 04:52:29'),
(32, NULL, 'he', NULL, 0, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 04:54:52', '2026-02-12 04:54:52'),
(33, NULL, 'he', NULL, 0, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 04:59:54', '2026-02-12 04:59:54'),
(34, NULL, 'tech', NULL, 0, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 05:00:00', '2026-02-12 05:00:00'),
(35, NULL, 'tech', NULL, 0, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 05:00:33', '2026-02-12 05:00:33'),
(36, NULL, 'tech', NULL, 0, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 05:04:58', '2026-02-12 05:04:58'),
(37, NULL, 'techs', NULL, 0, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 05:05:42', '2026-02-12 05:05:42'),
(38, NULL, 'tech', NULL, 0, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 05:05:48', '2026-02-12 05:05:48'),
(39, NULL, 'tech', NULL, 0, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 05:07:03', '2026-02-12 05:07:03'),
(40, NULL, 'techs', NULL, 0, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 05:07:08', '2026-02-12 05:07:08'),
(41, NULL, 'tech', NULL, 0, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 05:07:12', '2026-02-12 05:07:12'),
(42, NULL, 'tech', NULL, 0, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 05:07:16', '2026-02-12 05:07:16'),
(43, NULL, 'tech', NULL, 0, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 05:09:35', '2026-02-12 05:09:35'),
(44, NULL, 'tech', NULL, 0, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 05:10:28', '2026-02-12 05:10:28'),
(45, NULL, 'tech', NULL, 0, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 05:12:58', '2026-02-12 05:12:58'),
(46, NULL, 'techs', NULL, 0, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 05:13:02', '2026-02-12 05:13:02'),
(47, NULL, 'tech', NULL, 0, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 05:13:06', '2026-02-12 05:13:06'),
(48, NULL, 'tech', NULL, 0, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 05:14:47', '2026-02-12 05:14:47'),
(49, NULL, 'tech', NULL, 0, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 07:35:18', '2026-02-12 07:35:18'),
(50, NULL, 'tech', NULL, 0, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 08:11:12', '2026-02-12 08:11:12');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('BzbKGrOa1gIsYgOCaHBwr73smeCMZ9XNpAJqJmkn', 15, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiN0RiYU5OUDZ2cFZYdmExODc0dU45R2YwOTZDcmRzZmd4VEtHaExxTiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC93aWtpL3N0cm9uZ2VyIjtzOjU6InJvdXRlIjtzOjk6Indpa2kuc2hvdyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE1O30=', 1771281062),
('ifku2iLFfLeL8ipNtQmoamaOdZkcJImCMLIdYk6g', 15, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMThTU1h5Z1NxVVNUektnUkMybUFVMWtiVkZQcE5zU3A3bzN3QlRzMiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMzOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvd2lraS9jcmVhdGUiO3M6NToicm91dGUiO3M6MTE6Indpa2kuY3JlYXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTU7fQ==', 1771299860);

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `article_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `artist_id` bigint(20) UNSIGNED DEFAULT NULL,
  `genre_id` bigint(20) UNSIGNED DEFAULT NULL,
  `album` varchar(255) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `spotify_id` varchar(255) DEFAULT NULL,
  `youtube_id` varchar(255) DEFAULT NULL,
  `lyrics` longtext DEFAULT NULL,
  `producer` varchar(255) DEFAULT NULL,
  `songwriter` varchar(255) DEFAULT NULL,
  `studio_recorded` varchar(255) DEFAULT NULL,
  `behind_the_song` text DEFAULT NULL,
  `achievements` text DEFAULT NULL,
  `lyrics_snippet` text DEFAULT NULL,
  `record_label` varchar(255) DEFAULT NULL,
  `stream_count` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `last_stream_update` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `camelot_key` varchar(255) DEFAULT NULL COMMENT 'e.g. 8A, 9B'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`id`, `article_id`, `title`, `artist_id`, `genre_id`, `album`, `release_date`, `duration`, `spotify_id`, `youtube_id`, `lyrics`, `producer`, `songwriter`, `studio_recorded`, `behind_the_song`, `achievements`, `lyrics_snippet`, `record_label`, `stream_count`, `last_stream_update`, `created_at`, `updated_at`, `camelot_key`) VALUES
(1, 1, 'Sit rerum praesentium.', NULL, NULL, 'perferendis accusamus est', '1989-09-22', 243, NULL, NULL, 'At consequuntur autem cum rerum sunt iste dignissimos molestias. Sit est dolore ratione necessitatibus dolores necessitatibus amet. Veniam et vero et ut. Suscipit eos qui enim nulla ut est ullam.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 463151, NULL, '2026-01-25 06:04:12', '2026-01-25 06:04:12', NULL),
(2, 2, 'Itaque autem id iure.', NULL, NULL, 'assumenda at libero', '1983-10-27', 185, NULL, NULL, 'Enim voluptatem mollitia nisi et eius tempora. Sequi nihil quam architecto natus. A unde ab esse aliquid ratione.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 341365, NULL, '2026-01-25 06:04:12', '2026-01-25 06:04:12', NULL),
(3, 3, 'Itaque laboriosam fuga ducimus.', NULL, NULL, 'perferendis temporibus aut', '2024-10-04', 249, NULL, NULL, 'Nobis consectetur neque dolorem id ut nihil vel. Iusto voluptate velit consectetur ullam qui. Facilis sint error dicta ut ut.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 741899, NULL, '2026-01-25 06:04:12', '2026-01-25 06:04:12', NULL),
(4, 4, 'Vitae quidem aut.', NULL, NULL, 'laborum aut tempore', '1989-03-17', 235, NULL, NULL, 'Voluptates et aliquid neque. Dolorem voluptas quia et id natus nostrum. Similique et odit aspernatur consequatur temporibus voluptates veniam perspiciatis.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 239084, NULL, '2026-01-25 06:04:12', '2026-01-25 06:04:12', NULL),
(5, 5, 'Possimus voluptatem.', NULL, NULL, 'voluptas nihil minus', '1980-12-23', 183, NULL, NULL, 'Atque neque tempora debitis rerum quo. Quae rem voluptatem quos corrupti temporibus qui. Possimus esse sit omnis voluptas enim. Corporis veritatis distinctio similique dolores est dolor.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 806560, NULL, '2026-01-25 06:04:12', '2026-01-25 06:04:12', NULL),
(6, 6, 'Et pariatur repellat quia.', NULL, NULL, 'eveniet similique consequatur', '2022-06-02', 208, NULL, NULL, 'Odit tenetur id dolor mollitia beatae ut quo. Aut debitis numquam sit culpa. Aperiam sint dolorum et veritatis.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 257066, NULL, '2026-01-25 06:04:12', '2026-01-25 06:04:12', NULL),
(7, 7, 'Repudiandae mollitia ad nisi.', NULL, NULL, 'qui facilis et', '2001-06-08', 269, NULL, NULL, 'Sit quia optio aspernatur tenetur aut. Assumenda nesciunt qui non repudiandae molestiae. Culpa consequuntur ut modi vero minus molestias cupiditate.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 425862, NULL, '2026-01-25 06:04:12', '2026-01-25 06:04:12', NULL),
(8, 8, 'Dolor ut molestias.', NULL, NULL, 'voluptatum nam alias', '2008-04-29', 289, NULL, NULL, 'Impedit sapiente accusantium excepturi enim architecto facilis. Qui quaerat cupiditate reiciendis eos. Laborum possimus aspernatur aut et eaque.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 718568, NULL, '2026-01-25 06:04:12', '2026-01-25 06:04:12', NULL),
(9, 9, 'A eos quas.', NULL, NULL, 'ut fuga eaque', '1995-11-24', 227, NULL, NULL, 'Sint minima impedit ea quia. Aut aut itaque dolores doloribus et. Fugiat assumenda voluptas soluta impedit.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 938564, NULL, '2026-01-25 06:04:12', '2026-01-25 06:04:12', NULL),
(10, 10, 'Distinctio accusantium error.', NULL, NULL, 'ipsam inventore nam', '1970-01-01', 223, NULL, NULL, 'Ipsum vel amet ad tempore amet. Minima veritatis qui molestiae et ipsum. In illum architecto saepe vero tenetur explicabo. Veritatis vitae beatae qui doloribus.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 34023, NULL, '2026-01-25 06:04:12', '2026-01-25 06:04:12', NULL),
(11, 37, 'teststest', NULL, NULL, NULL, '1970-01-01', NULL, NULL, NULL, NULL, NULL, 'test', 'test', 'stest', 'stest', 'test', NULL, 0, NULL, '2026-02-08 08:16:54', '2026-02-08 08:16:54', NULL),
(12, 39, 'Cola Bottle Baby', 2, NULL, NULL, '1979-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-02-13 04:23:15', '2026-02-13 04:23:15', NULL),
(13, 40, 'Harder, Better, Faster, Stronger', 1, NULL, NULL, '2001-10-13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-02-13 04:23:15', '2026-02-13 04:23:15', NULL),
(14, 41, 'Stronger', 3, NULL, NULL, '2007-07-31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-02-13 04:23:15', '2026-02-13 04:23:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `article_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phonetic` varchar(255) DEFAULT NULL,
  `origin_language` varchar(255) DEFAULT NULL,
  `category_type` varchar(255) DEFAULT NULL,
  `related_terms` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`related_terms`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`id`, `article_id`, `name`, `phonetic`, `origin_language`, `category_type`, `related_terms`, `created_at`, `updated_at`) VALUES
(3, 33, 'Reverb', '/rɪˈvɜːb/', 'Latin', 'theory', '[\"Delay\",\"Echo\",\"Acoustics\"]', '2026-01-31 05:36:41', '2026-01-31 05:36:41'),
(4, 34, 'Syncopation', '/ˌsɪŋkəˈpeɪʃn/', 'Greek', 'theory', '[\"Polyrhythm\",\"Groove\",\"Tempo\"]', '2026-01-31 05:36:41', '2026-01-31 05:36:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `spotify_id` varchar(255) DEFAULT NULL,
  `spotify_token` text DEFAULT NULL,
  `spotify_refresh_token` text DEFAULT NULL,
  `spotify_token_expires_at` timestamp NULL DEFAULT NULL,
  `spotify_now_playing` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`spotify_now_playing`)),
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `reputation_score` int(11) NOT NULL DEFAULT 0,
  `avatar` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `spotify_id`, `spotify_token`, `spotify_refresh_token`, `spotify_token_expires_at`, `spotify_now_playing`, `email_verified_at`, `password`, `role`, `reputation_score`, `avatar`, `bio`, `location`, `website`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin User', 'admin-user-1', 'admin@chaynwiki.com', NULL, NULL, NULL, NULL, NULL, '2026-01-25 06:04:11', '$2y$12$g1xDHOzRRuun89Crm4Bu8OJbeXLKqPLYpp4SkIQuE7EcasJ0enSRS', 'admin', 0, NULL, NULL, NULL, NULL, 'l8lfCiCPSa', '2026-01-25 06:04:11', '2026-01-25 06:11:49', NULL),
(2, 'John Doe', 'john-doe-2', 'john@example.com', NULL, NULL, NULL, NULL, NULL, '2026-01-25 06:04:11', '$2y$12$owoOnvbPVjUq3gvqDptoXOIm1SeZ/9ktyMCnSS9IzhZ5QDJddSFFi', 'user', 0, NULL, NULL, NULL, NULL, 'TFkGm30YpY', '2026-01-25 06:04:11', '2026-01-25 06:11:49', NULL),
(3, 'Arjun Kunze MD', 'arjun-kunze-md-3', 'becker.erin@example.net', NULL, NULL, NULL, NULL, NULL, '2026-01-25 06:04:12', '$2y$12$oHfVfsScSFYAGSnFkZ7G6Okk.puuKSARCV.42Gb5dhDwwZvoPMOwi', 'user', 0, NULL, NULL, NULL, NULL, '2wP1yc3gdt', '2026-01-25 06:04:12', '2026-01-25 06:11:49', NULL),
(4, 'Otilia Rodriguez II', 'otilia-rodriguez-ii-4', 'hessel.birdie@example.net', NULL, NULL, NULL, NULL, NULL, '2026-01-25 06:04:12', '$2y$12$oHfVfsScSFYAGSnFkZ7G6Okk.puuKSARCV.42Gb5dhDwwZvoPMOwi', 'user', 0, NULL, NULL, NULL, NULL, '56Kzko60Oi', '2026-01-25 06:04:12', '2026-01-25 06:11:49', NULL),
(5, 'Mr. Thaddeus Ebert I', 'mr-thaddeus-ebert-i-5', 'jfeeney@example.com', NULL, NULL, NULL, NULL, NULL, '2026-01-25 06:04:12', '$2y$12$oHfVfsScSFYAGSnFkZ7G6Okk.puuKSARCV.42Gb5dhDwwZvoPMOwi', 'user', 0, NULL, NULL, NULL, NULL, 'dL3IMQb3le', '2026-01-25 06:04:12', '2026-01-25 06:11:49', NULL),
(6, 'Shayna Jacobson', 'shayna-jacobson-6', 'lucie15@example.net', NULL, NULL, NULL, NULL, NULL, '2026-01-25 06:04:12', '$2y$12$oHfVfsScSFYAGSnFkZ7G6Okk.puuKSARCV.42Gb5dhDwwZvoPMOwi', 'user', 0, NULL, NULL, NULL, NULL, 'JIwzbRQt6K', '2026-01-25 06:04:12', '2026-01-25 06:11:49', NULL),
(7, 'Miss Maryjane Bailey I', 'miss-maryjane-bailey-i-7', 'gbergstrom@example.com', NULL, NULL, NULL, NULL, NULL, '2026-01-25 06:04:12', '$2y$12$oHfVfsScSFYAGSnFkZ7G6Okk.puuKSARCV.42Gb5dhDwwZvoPMOwi', 'user', 0, NULL, NULL, NULL, NULL, 'UlFy9s4ERI', '2026-01-25 06:04:12', '2026-01-25 06:11:49', NULL),
(8, 'Miss Clemmie Kuhic', 'miss-clemmie-kuhic-8', 'annamae60@example.net', NULL, NULL, NULL, NULL, NULL, '2026-01-25 06:04:12', '$2y$12$oHfVfsScSFYAGSnFkZ7G6Okk.puuKSARCV.42Gb5dhDwwZvoPMOwi', 'user', 0, NULL, NULL, NULL, NULL, 'QKWwRAY2qM', '2026-01-25 06:04:12', '2026-01-25 06:11:49', NULL),
(9, 'Gilda Lubowitz II', 'gilda-lubowitz-ii-9', 'colt68@example.org', NULL, NULL, NULL, NULL, NULL, '2026-01-25 06:04:12', '$2y$12$oHfVfsScSFYAGSnFkZ7G6Okk.puuKSARCV.42Gb5dhDwwZvoPMOwi', 'user', 0, NULL, NULL, NULL, NULL, 'SPFbsJXi4P', '2026-01-25 06:04:12', '2026-01-25 06:11:49', NULL),
(10, 'Ervin Kunze DVM', 'ervin-kunze-dvm-10', 'froob@example.net', NULL, NULL, NULL, NULL, NULL, '2026-01-25 06:04:12', '$2y$12$oHfVfsScSFYAGSnFkZ7G6Okk.puuKSARCV.42Gb5dhDwwZvoPMOwi', 'user', 0, NULL, NULL, NULL, NULL, 'FXGpTYuOHH', '2026-01-25 06:04:12', '2026-01-25 06:11:49', NULL),
(11, 'Russell Ryan', 'russell-ryan-11', 'domenica.beatty@example.org', NULL, NULL, NULL, NULL, NULL, '2026-01-25 06:04:12', '$2y$12$oHfVfsScSFYAGSnFkZ7G6Okk.puuKSARCV.42Gb5dhDwwZvoPMOwi', 'user', 0, NULL, NULL, NULL, NULL, 'IBdZCs3jLx', '2026-01-25 06:04:12', '2026-01-25 06:11:49', NULL),
(12, 'Prof. Johnathon Beatty', 'prof-johnathon-beatty-12', 'bogan.larue@example.org', NULL, NULL, NULL, NULL, NULL, '2026-01-25 06:04:12', '$2y$12$oHfVfsScSFYAGSnFkZ7G6Okk.puuKSARCV.42Gb5dhDwwZvoPMOwi', 'user', 0, NULL, NULL, NULL, NULL, 'nIvoInmrva', '2026-01-25 06:04:12', '2026-01-25 06:11:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_achievements`
--

CREATE TABLE `user_achievements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `achievement_id` bigint(20) UNSIGNED NOT NULL,
  `progress` int(11) NOT NULL DEFAULT 0,
  `earned_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_crates`
--

CREATE TABLE `user_crates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT 0,
  `color_accent` varchar(255) DEFAULT NULL,
  `views_count` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_crates`
--

INSERT INTO `user_crates` (`id`, `user_id`, `name`, `slug`, `description`, `is_public`, `color_accent`, `views_count`, `created_at`, `updated_at`) VALUES
(2, 1, 'Community Gems', 'community-gems-107', 'A curated selection of the best musical records from the community.', 1, '#3b82f6', 0, '2026-02-11 11:13:56', '2026-02-11 11:13:56');

-- --------------------------------------------------------

--
-- Table structure for table `user_streaks`
--

CREATE TABLE `user_streaks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'daily',
  `current_streak` int(11) NOT NULL DEFAULT 0,
  `longest_streak` int(11) NOT NULL DEFAULT 0,
  `last_activity_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE `views` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `article_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `views`
--

INSERT INTO `views` (`id`, `article_id`, `user_id`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, 5, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-30 02:48:12', '2026-01-30 02:48:12'),
(2, 11, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-30 06:26:37', '2026-01-30 06:26:37'),
(3, 10, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-30 08:17:41', '2026-01-30 08:17:41'),
(4, 18, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-30 08:19:41', '2026-01-30 08:19:41'),
(5, 19, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-30 08:20:10', '2026-01-30 08:20:10'),
(6, 19, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-30 11:36:19', '2026-01-30 11:36:19'),
(7, 1, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-30 13:38:15', '2026-01-30 13:38:15'),
(8, 35, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 05:43:37', '2026-01-31 05:43:37'),
(9, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 05:45:23', '2026-01-31 05:45:23'),
(10, 19, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 05:45:36', '2026-01-31 05:45:36'),
(11, 35, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 05:46:16', '2026-01-31 05:46:16'),
(12, 35, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 05:52:43', '2026-01-31 05:52:43'),
(13, 25, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 05:55:43', '2026-01-31 05:55:43'),
(14, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 09:41:46', '2026-01-31 09:41:46'),
(15, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 09:42:50', '2026-01-31 09:42:50'),
(16, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 09:43:27', '2026-01-31 09:43:27'),
(17, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 09:46:28', '2026-01-31 09:46:28'),
(18, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 09:46:45', '2026-01-31 09:46:45'),
(19, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 09:48:04', '2026-01-31 09:48:04'),
(20, 25, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 11:25:01', '2026-01-31 11:25:01'),
(21, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 11:25:19', '2026-01-31 11:25:19'),
(22, 25, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 11:28:28', '2026-01-31 11:28:28'),
(23, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 11:33:52', '2026-01-31 11:33:52'),
(24, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 11:36:06', '2026-01-31 11:36:06'),
(25, 25, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 11:58:11', '2026-01-31 11:58:11'),
(26, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 12:01:42', '2026-01-31 12:01:42'),
(27, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 12:03:26', '2026-01-31 12:03:26'),
(28, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 12:05:04', '2026-01-31 12:05:04'),
(29, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 12:07:43', '2026-01-31 12:07:43'),
(30, 25, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 12:10:03', '2026-01-31 12:10:03'),
(31, 25, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 12:10:17', '2026-01-31 12:10:17'),
(32, 25, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 12:10:48', '2026-01-31 12:10:48'),
(33, 25, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 12:14:09', '2026-01-31 12:14:09'),
(34, 25, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 12:16:17', '2026-01-31 12:16:17'),
(35, 25, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 12:17:31', '2026-01-31 12:17:31'),
(36, 25, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 12:20:14', '2026-01-31 12:20:14'),
(37, 25, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 12:20:32', '2026-01-31 12:20:32'),
(38, 25, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 12:20:44', '2026-01-31 12:20:44'),
(39, 25, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 12:20:50', '2026-01-31 12:20:50'),
(40, 25, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 12:23:04', '2026-01-31 12:23:04'),
(41, 25, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 12:24:39', '2026-01-31 12:24:39'),
(42, 25, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 12:24:43', '2026-01-31 12:24:43'),
(43, 25, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 12:26:04', '2026-01-31 12:26:04'),
(44, 25, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 12:27:58', '2026-01-31 12:27:58'),
(45, 25, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 12:31:25', '2026-01-31 12:31:25'),
(46, 25, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 12:39:51', '2026-01-31 12:39:51'),
(47, 25, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 12:42:17', '2026-01-31 12:42:17'),
(48, 24, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 13:12:28', '2026-01-31 13:12:28'),
(49, 19, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 13:28:42', '2026-01-31 13:28:42'),
(50, 19, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 13:33:05', '2026-01-31 13:33:05'),
(51, 19, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 13:35:00', '2026-01-31 13:35:00'),
(52, 19, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 13:36:56', '2026-01-31 13:36:56'),
(53, 25, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 13:37:26', '2026-01-31 13:37:26'),
(54, 18, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 13:37:45', '2026-01-31 13:37:45'),
(55, 34, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-31 13:38:24', '2026-01-31 13:38:24'),
(56, 34, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-01 13:44:31', '2026-02-01 13:44:31'),
(57, 34, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-01 13:47:24', '2026-02-01 13:47:24'),
(58, 34, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-01 13:48:25', '2026-02-01 13:48:25'),
(59, 34, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-01 13:50:05', '2026-02-01 13:50:05'),
(60, 34, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-01 13:51:13', '2026-02-01 13:51:13'),
(61, 22, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-01 14:08:39', '2026-02-01 14:08:39'),
(62, 35, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-01 14:09:07', '2026-02-01 14:09:07'),
(63, 18, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-01 14:10:25', '2026-02-01 14:10:25'),
(64, 19, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-01 14:11:18', '2026-02-01 14:11:18'),
(65, 35, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-01 14:11:34', '2026-02-01 14:11:34'),
(66, 35, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-01 14:11:57', '2026-02-01 14:11:57'),
(67, 18, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-01 14:13:58', '2026-02-01 14:13:58'),
(68, 18, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-01 14:14:32', '2026-02-01 14:14:32'),
(69, 18, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-01 14:14:59', '2026-02-01 14:14:59'),
(70, 35, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-01 14:17:24', '2026-02-01 14:17:24'),
(71, 35, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-01 14:17:48', '2026-02-01 14:17:48'),
(72, 18, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-01 14:18:52', '2026-02-01 14:18:52'),
(73, 25, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-01 14:19:22', '2026-02-01 14:19:22'),
(74, 10, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-01 14:19:50', '2026-02-01 14:19:50'),
(75, 11, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-01 14:20:06', '2026-02-01 14:20:06'),
(76, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-01 14:20:35', '2026-02-01 14:20:35'),
(77, 35, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-01 14:20:53', '2026-02-01 14:20:53'),
(78, 18, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 11:51:47', '2026-02-03 11:51:47'),
(79, 36, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 11:54:26', '2026-02-03 11:54:26'),
(80, 17, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 12:02:19', '2026-02-03 12:02:19'),
(81, 17, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 12:11:16', '2026-02-03 12:11:16'),
(82, 36, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 12:26:14', '2026-02-03 12:26:14'),
(83, 35, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 12:26:31', '2026-02-03 12:26:31'),
(84, 34, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 12:26:46', '2026-02-03 12:26:46'),
(85, 33, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 12:27:09', '2026-02-03 12:27:09'),
(86, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 12:27:46', '2026-02-03 12:27:46'),
(87, 25, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 12:28:00', '2026-02-03 12:28:00'),
(88, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 12:28:27', '2026-02-03 12:28:27'),
(89, 36, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 12:29:08', '2026-02-03 12:29:08'),
(90, 25, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 12:51:19', '2026-02-03 12:51:19'),
(91, 25, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 12:52:56', '2026-02-03 12:52:56'),
(92, 25, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 12:55:07', '2026-02-03 12:55:07'),
(93, 17, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 12:55:40', '2026-02-03 12:55:40'),
(94, 17, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 12:57:05', '2026-02-03 12:57:05'),
(95, 17, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 12:58:52', '2026-02-03 12:58:52'),
(96, 36, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 12:59:04', '2026-02-03 12:59:04'),
(97, 36, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 13:01:01', '2026-02-03 13:01:01'),
(98, 36, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 13:03:55', '2026-02-03 13:03:55'),
(99, 14, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 13:17:13', '2026-02-03 13:17:13'),
(100, 36, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 13:18:24', '2026-02-03 13:18:24'),
(101, 17, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.108.2 Chrome/142.0.7444.235 Electron/39.2.7 Safari/537.36', '2026-02-03 13:44:32', '2026-02-03 13:44:32'),
(102, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 15:31:24', '2026-02-03 15:31:24'),
(103, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 15:40:40', '2026-02-03 15:40:40'),
(104, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 15:43:32', '2026-02-03 15:43:32'),
(105, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 15:56:44', '2026-02-03 15:56:44'),
(106, 25, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 16:04:49', '2026-02-03 16:04:49'),
(107, 34, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 16:35:04', '2026-02-03 16:35:04'),
(108, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-04 00:47:40', '2026-02-04 00:47:40'),
(109, 17, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-04 00:48:19', '2026-02-04 00:48:19'),
(110, 35, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-07 12:43:03', '2026-02-07 12:43:03'),
(111, 35, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-07 13:37:24', '2026-02-07 13:37:24'),
(112, 35, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-07 14:19:10', '2026-02-07 14:19:10'),
(113, 16, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-07 16:10:56', '2026-02-07 16:10:56'),
(114, 33, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 05:05:03', '2026-02-08 05:05:03'),
(115, 27, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 05:09:27', '2026-02-08 05:09:27'),
(116, 36, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 05:17:43', '2026-02-08 05:17:43'),
(117, 33, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 07:24:19', '2026-02-08 07:24:19'),
(118, 10, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 07:42:29', '2026-02-08 07:42:29'),
(119, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 07:54:43', '2026-02-08 07:54:43'),
(120, 18, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 08:10:18', '2026-02-08 08:10:18'),
(121, 35, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 08:14:44', '2026-02-08 08:14:44'),
(122, 36, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 08:15:50', '2026-02-08 08:15:50'),
(123, 36, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 09:19:57', '2026-02-08 09:19:57'),
(124, 37, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 09:20:05', '2026-02-08 09:20:05'),
(125, 37, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 09:35:50', '2026-02-08 09:35:50'),
(126, 37, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 09:42:53', '2026-02-08 09:42:53'),
(127, 37, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 09:46:28', '2026-02-08 09:46:28'),
(128, 16, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 09:57:40', '2026-02-08 09:57:40'),
(129, 16, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 10:04:47', '2026-02-08 10:04:47'),
(130, 34, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 10:04:56', '2026-02-08 10:04:56'),
(131, 18, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 10:07:20', '2026-02-08 10:07:20'),
(132, 34, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 10:07:24', '2026-02-08 10:07:24'),
(133, 34, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 10:07:38', '2026-02-08 10:07:38'),
(134, 34, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 10:14:29', '2026-02-08 10:14:29'),
(135, 34, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 10:20:32', '2026-02-08 10:20:32'),
(136, 37, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 10:21:28', '2026-02-08 10:21:28'),
(137, 37, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 10:23:07', '2026-02-08 10:23:07'),
(138, 37, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 10:23:12', '2026-02-08 10:23:12'),
(139, 34, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 10:23:22', '2026-02-08 10:23:22'),
(140, 34, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 10:27:45', '2026-02-08 10:27:45'),
(141, 36, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 10:27:54', '2026-02-08 10:27:54'),
(142, 36, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 10:28:13', '2026-02-08 10:28:13'),
(143, 37, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 10:29:06', '2026-02-08 10:29:06'),
(144, 35, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 10:29:41', '2026-02-08 10:29:41'),
(145, 33, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 10:29:47', '2026-02-08 10:29:47'),
(146, 37, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 10:29:54', '2026-02-08 10:29:54'),
(147, 18, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 10:30:01', '2026-02-08 10:30:01'),
(148, 18, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 10:30:31', '2026-02-08 10:30:31'),
(149, 18, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 10:36:15', '2026-02-08 10:36:15'),
(150, 37, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 12:04:22', '2026-02-08 12:04:22'),
(151, 37, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 12:04:36', '2026-02-08 12:04:36'),
(152, 37, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 12:04:57', '2026-02-08 12:04:57'),
(153, 17, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 12:22:00', '2026-02-08 12:22:00'),
(154, 37, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 12:22:37', '2026-02-08 12:22:37'),
(155, 4, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 12:48:10', '2026-02-08 12:48:10'),
(156, 4, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 12:48:48', '2026-02-08 12:48:48'),
(157, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 12:49:11', '2026-02-08 12:49:11'),
(158, 37, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 12:51:46', '2026-02-08 12:51:46'),
(159, 37, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 12:58:49', '2026-02-08 12:58:49'),
(160, 38, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 12:59:53', '2026-02-08 12:59:53'),
(161, 21, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 13:08:05', '2026-02-08 13:08:05'),
(162, 17, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 13:12:31', '2026-02-08 13:12:31'),
(163, 37, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-09 11:39:41', '2026-02-09 11:39:41'),
(164, 37, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-10 15:38:19', '2026-02-10 15:38:19'),
(165, 35, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-10 15:39:05', '2026-02-10 15:39:05'),
(166, 37, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-10 15:40:16', '2026-02-10 15:40:16'),
(167, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-10 16:19:42', '2026-02-10 16:19:42'),
(168, 37, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-10 17:51:09', '2026-02-10 17:51:09'),
(169, 17, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-10 17:51:29', '2026-02-10 17:51:29'),
(170, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-10 19:00:38', '2026-02-10 19:00:38'),
(171, 38, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 01:39:18', '2026-02-11 01:39:18'),
(172, 38, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 01:40:27', '2026-02-11 01:40:27'),
(173, 38, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 01:43:37', '2026-02-11 01:43:37'),
(174, 38, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 01:44:31', '2026-02-11 01:44:31'),
(175, 38, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 01:45:43', '2026-02-11 01:45:43'),
(176, 38, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 01:49:26', '2026-02-11 01:49:26'),
(177, 38, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 01:53:22', '2026-02-11 01:53:22'),
(178, 38, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 01:55:04', '2026-02-11 01:55:04'),
(179, 38, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 01:58:37', '2026-02-11 01:58:37'),
(180, 36, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 01:59:06', '2026-02-11 01:59:06'),
(181, 36, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 01:59:49', '2026-02-11 01:59:49'),
(182, 36, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 02:03:07', '2026-02-11 02:03:07'),
(183, 36, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 02:03:28', '2026-02-11 02:03:28'),
(184, 36, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 02:05:07', '2026-02-11 02:05:07'),
(185, 36, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 02:06:10', '2026-02-11 02:06:10'),
(186, 36, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 02:07:09', '2026-02-11 02:07:09'),
(187, 36, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 02:08:50', '2026-02-11 02:08:50'),
(188, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 02:11:59', '2026-02-11 02:11:59'),
(189, 35, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 02:20:57', '2026-02-11 02:20:57'),
(190, 38, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 02:23:31', '2026-02-11 02:23:31'),
(191, 38, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 02:24:25', '2026-02-11 02:24:25'),
(192, 38, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 02:24:53', '2026-02-11 02:24:53'),
(193, 38, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 02:30:14', '2026-02-11 02:30:14'),
(194, 37, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 02:30:34', '2026-02-11 02:30:34'),
(195, 15, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 02:31:30', '2026-02-11 02:31:30'),
(196, 15, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 02:31:51', '2026-02-11 02:31:51'),
(197, 15, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 02:33:52', '2026-02-11 02:33:52'),
(198, 15, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 02:34:07', '2026-02-11 02:34:07'),
(199, 37, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 02:35:06', '2026-02-11 02:35:06'),
(200, 38, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 02:43:32', '2026-02-11 02:43:32'),
(201, 37, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 05:58:46', '2026-02-11 05:58:46'),
(202, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 05:59:54', '2026-02-11 05:59:54'),
(203, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 06:03:02', '2026-02-11 06:03:02'),
(204, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 06:06:37', '2026-02-11 06:06:37'),
(205, 18, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 08:19:30', '2026-02-11 08:19:30'),
(206, 36, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 08:46:18', '2026-02-11 08:46:18'),
(207, 22, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 08:54:04', '2026-02-11 08:54:04'),
(208, 36, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 08:54:17', '2026-02-11 08:54:17'),
(209, 18, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 08:54:33', '2026-02-11 08:54:33'),
(210, 36, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 10:34:25', '2026-02-11 10:34:25'),
(211, 18, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 11:01:16', '2026-02-11 11:01:16'),
(212, 37, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 11:01:37', '2026-02-11 11:01:37'),
(213, 24, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 01:11:55', '2026-02-12 01:11:55'),
(214, 25, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 03:35:47', '2026-02-12 03:35:47'),
(215, 25, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 03:35:47', '2026-02-12 03:35:47'),
(216, 25, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 03:38:01', '2026-02-12 03:38:01'),
(217, 25, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 03:44:28', '2026-02-12 03:44:28'),
(218, 14, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 04:00:08', '2026-02-12 04:00:08'),
(219, 14, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 04:03:15', '2026-02-12 04:03:15'),
(220, 14, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 04:03:21', '2026-02-12 04:03:21'),
(221, 14, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 04:04:33', '2026-02-12 04:04:33'),
(222, 14, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 04:04:57', '2026-02-12 04:04:57'),
(223, 14, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 04:07:20', '2026-02-12 04:07:20'),
(224, 7, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 04:14:34', '2026-02-12 04:14:34'),
(225, 25, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 04:15:23', '2026-02-12 04:15:23'),
(226, 25, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 04:15:29', '2026-02-12 04:15:29'),
(227, 7, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 05:42:48', '2026-02-12 05:42:48'),
(228, 9, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 05:50:28', '2026-02-12 05:50:28'),
(229, 37, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 05:50:43', '2026-02-12 05:50:43'),
(230, 33, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 05:50:50', '2026-02-12 05:50:50'),
(231, 24, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 06:06:22', '2026-02-12 06:06:22'),
(232, 37, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 06:21:48', '2026-02-12 06:21:48'),
(233, 6, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 06:25:46', '2026-02-12 06:25:46'),
(234, 35, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 06:26:31', '2026-02-12 06:26:31'),
(235, 22, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 06:26:43', '2026-02-12 06:26:43'),
(236, 13, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 06:28:52', '2026-02-12 06:28:52'),
(237, 11, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 06:51:22', '2026-02-12 06:51:22'),
(238, 36, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 06:51:32', '2026-02-12 06:51:32'),
(239, 18, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 06:51:44', '2026-02-12 06:51:44'),
(240, 37, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 07:28:31', '2026-02-12 07:28:31'),
(241, 21, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 07:29:19', '2026-02-12 07:29:19'),
(242, 21, 1, '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', '2026-02-12 07:30:21', '2026-02-12 07:30:21'),
(243, 18, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 04:14:10', '2026-02-13 04:14:10'),
(244, 21, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 04:14:43', '2026-02-13 04:14:43'),
(245, 37, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 04:15:14', '2026-02-13 04:15:14'),
(246, 37, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 04:25:36', '2026-02-13 04:25:36'),
(247, 17, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 04:35:10', '2026-02-13 04:35:10'),
(248, 17, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 04:35:29', '2026-02-13 04:35:29'),
(249, 17, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 04:35:33', '2026-02-13 04:35:33'),
(250, 17, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 04:36:39', '2026-02-13 04:36:39'),
(251, 25, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 04:37:31', '2026-02-13 04:37:31'),
(252, 37, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 04:40:58', '2026-02-13 04:40:58'),
(253, 39, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 04:41:06', '2026-02-13 04:41:06'),
(254, 17, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 04:41:41', '2026-02-13 04:41:41'),
(255, 17, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 04:45:31', '2026-02-13 04:45:31'),
(256, 37, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 04:45:45', '2026-02-13 04:45:45'),
(257, 37, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 04:48:20', '2026-02-13 04:48:20'),
(258, 37, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 04:48:25', '2026-02-13 04:48:25'),
(259, 37, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 04:50:58', '2026-02-13 04:50:58'),
(260, 18, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 04:52:18', '2026-02-13 04:52:18'),
(261, 18, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 04:57:25', '2026-02-13 04:57:25'),
(262, 18, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 04:57:43', '2026-02-13 04:57:43'),
(263, 24, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 04:58:18', '2026-02-13 04:58:18'),
(264, 24, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 05:04:14', '2026-02-13 05:04:14'),
(265, 24, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 05:17:58', '2026-02-13 05:17:58'),
(266, 18, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 05:18:17', '2026-02-13 05:18:17');
INSERT INTO `views` (`id`, `article_id`, `user_id`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(267, 36, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 05:21:13', '2026-02-13 05:21:13'),
(268, 37, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 05:21:22', '2026-02-13 05:21:22'),
(269, 18, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 05:26:33', '2026-02-13 05:26:33'),
(270, 39, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 05:26:49', '2026-02-13 05:26:49'),
(271, 18, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 05:28:22', '2026-02-13 05:28:22'),
(272, 36, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 05:28:48', '2026-02-13 05:28:48'),
(273, 24, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 05:28:59', '2026-02-13 05:28:59'),
(274, 24, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 05:43:23', '2026-02-13 05:43:23'),
(275, 24, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 05:47:17', '2026-02-13 05:47:17'),
(276, 22, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 05:47:26', '2026-02-13 05:47:26'),
(277, 25, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 05:47:51', '2026-02-13 05:47:51'),
(278, 25, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 05:47:52', '2026-02-13 05:47:52'),
(279, 25, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 05:48:38', '2026-02-13 05:48:38'),
(280, 25, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 06:28:54', '2026-02-13 06:28:54'),
(281, 25, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 06:28:54', '2026-02-13 06:28:54'),
(282, 25, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 06:29:19', '2026-02-13 06:29:19'),
(283, 25, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 06:34:48', '2026-02-13 06:34:48'),
(284, 37, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 06:34:56', '2026-02-13 06:34:56'),
(285, 24, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 06:35:12', '2026-02-13 06:35:12'),
(286, 18, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 06:35:17', '2026-02-13 06:35:17'),
(287, 34, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 06:35:40', '2026-02-13 06:35:40'),
(288, 18, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 06:36:24', '2026-02-13 06:36:24'),
(289, 25, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 06:37:19', '2026-02-13 06:37:19'),
(290, 35, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 06:37:31', '2026-02-13 06:37:31'),
(291, 39, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 06:37:36', '2026-02-13 06:37:36'),
(292, 14, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 06:37:42', '2026-02-13 06:37:42'),
(293, 18, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 06:40:21', '2026-02-13 06:40:21'),
(294, 39, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 06:47:33', '2026-02-13 06:47:33'),
(295, 39, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 06:49:10', '2026-02-13 06:49:10'),
(296, 39, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 06:49:14', '2026-02-13 06:49:14'),
(297, 25, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 06:49:19', '2026-02-13 06:49:19'),
(298, 36, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 06:49:46', '2026-02-13 06:49:46'),
(299, 34, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 06:50:00', '2026-02-13 06:50:00'),
(300, 17, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 06:50:15', '2026-02-13 06:50:15'),
(301, 39, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 06:50:32', '2026-02-13 06:50:32'),
(302, 17, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 06:52:58', '2026-02-13 06:52:58'),
(303, 36, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 06:53:10', '2026-02-13 06:53:10'),
(304, 1, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 06:53:43', '2026-02-13 06:53:43'),
(305, 1, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 09:08:30', '2026-02-13 09:08:30'),
(306, 18, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 09:08:35', '2026-02-13 09:08:35'),
(307, 18, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 09:13:08', '2026-02-13 09:13:08'),
(308, 40, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 09:13:30', '2026-02-13 09:13:30'),
(309, 15, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 09:13:50', '2026-02-13 09:13:50'),
(310, 15, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 09:18:16', '2026-02-13 09:18:16'),
(311, 15, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 09:22:10', '2026-02-13 09:22:10'),
(312, 1, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 09:23:53', '2026-02-13 09:23:53'),
(313, 27, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 09:26:06', '2026-02-13 09:26:06'),
(314, 18, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 09:31:38', '2026-02-13 09:31:38'),
(315, 14, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 09:32:03', '2026-02-13 09:32:03'),
(316, 28, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 09:36:08', '2026-02-13 09:36:08'),
(317, 28, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 09:36:35', '2026-02-13 09:36:35'),
(318, 28, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 09:36:39', '2026-02-13 09:36:39'),
(319, 24, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 09:36:45', '2026-02-13 09:36:45'),
(320, 17, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 09:36:51', '2026-02-13 09:36:51'),
(321, 18, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 09:42:21', '2026-02-13 09:42:21'),
(322, 24, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 09:47:44', '2026-02-13 09:47:44'),
(323, 37, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 09:47:55', '2026-02-13 09:47:55'),
(324, 17, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 09:48:00', '2026-02-13 09:48:00'),
(325, 34, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 09:48:13', '2026-02-13 09:48:13'),
(326, 36, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 09:48:22', '2026-02-13 09:48:22'),
(327, 40, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 09:48:38', '2026-02-13 09:48:38'),
(328, 40, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 09:56:40', '2026-02-13 09:56:40'),
(329, 34, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 09:56:49', '2026-02-13 09:56:49'),
(330, 22, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 09:57:12', '2026-02-13 09:57:12'),
(331, 18, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 09:57:23', '2026-02-13 09:57:23'),
(332, 35, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 09:57:38', '2026-02-13 09:57:38'),
(333, 41, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 12:25:45', '2026-02-13 12:25:45'),
(334, 24, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 12:26:09', '2026-02-13 12:26:09'),
(335, 39, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 12:28:15', '2026-02-13 12:28:15'),
(336, 1, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 12:30:02', '2026-02-13 12:30:02'),
(337, 41, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 12:36:41', '2026-02-13 12:36:41'),
(338, 25, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 12:36:59', '2026-02-13 12:36:59'),
(339, 39, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 12:37:27', '2026-02-13 12:37:27'),
(340, 18, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 12:37:49', '2026-02-13 12:37:49'),
(341, 41, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 13:27:52', '2026-02-13 13:27:52'),
(342, 41, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 13:35:26', '2026-02-13 13:35:26'),
(343, 41, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 13:50:29', '2026-02-13 13:50:29'),
(344, 18, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-13 13:51:19', '2026-02-13 13:51:19'),
(345, 16, NULL, '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', '2026-02-13 15:16:23', '2026-02-13 15:16:23'),
(346, 25, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-15 01:39:48', '2026-02-15 01:39:48'),
(347, 41, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-15 01:40:11', '2026-02-15 01:40:11'),
(348, 18, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-15 01:40:29', '2026-02-15 01:40:29'),
(349, 34, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-15 01:40:48', '2026-02-15 01:40:48'),
(350, 1, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-15 01:41:00', '2026-02-15 01:41:00'),
(351, 40, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-16 14:53:15', '2026-02-16 14:53:15'),
(352, 40, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-16 14:56:21', '2026-02-16 14:56:21'),
(353, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-16 14:56:53', '2026-02-16 14:56:53'),
(354, 14, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-16 14:57:08', '2026-02-16 14:57:08'),
(355, 14, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-16 15:02:48', '2026-02-16 15:02:48'),
(356, 17, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-16 15:04:01', '2026-02-16 15:04:01'),
(357, 18, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-16 15:23:13', '2026-02-16 15:23:13'),
(358, 39, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-16 15:24:17', '2026-02-16 15:24:17'),
(359, 39, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-16 15:53:32', '2026-02-16 15:53:32'),
(360, 39, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-16 15:53:37', '2026-02-16 15:53:37'),
(361, 34, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-16 15:53:52', '2026-02-16 15:53:52'),
(362, 3, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-16 15:54:26', '2026-02-16 15:54:26'),
(363, 3, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-16 15:59:30', '2026-02-16 15:59:30'),
(364, 39, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-16 15:59:45', '2026-02-16 15:59:45'),
(365, 17, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-16 16:00:04', '2026-02-16 16:00:04'),
(366, 28, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-16 16:00:22', '2026-02-16 16:00:22'),
(367, 25, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-16 16:00:39', '2026-02-16 16:00:39'),
(368, 2, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-16 16:01:01', '2026-02-16 16:01:01'),
(369, 14, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-16 16:20:41', '2026-02-16 16:20:41'),
(370, 40, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-16 16:21:00', '2026-02-16 16:21:00'),
(371, 18, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-16 16:21:14', '2026-02-16 16:21:14'),
(372, 35, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-16 16:21:24', '2026-02-16 16:21:24'),
(373, 24, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-16 17:28:13', '2026-02-16 17:28:13'),
(374, 39, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-16 17:28:28', '2026-02-16 17:28:28'),
(375, 41, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-16 17:31:01', '2026-02-16 17:31:01');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `votable_type` varchar(255) NOT NULL,
  `votable_id` bigint(20) UNSIGNED NOT NULL,
  `value` int(11) NOT NULL,
  `score` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `user_id`, `votable_type`, `votable_id`, `value`, `score`, `created_at`, `updated_at`) VALUES
(6, 1, 'App\\Models\\Article', 25, 1, NULL, '2026-01-31 12:42:38', '2026-01-31 12:42:38');

-- --------------------------------------------------------

--
-- Table structure for table `wantlist_votes`
--

CREATE TABLE `wantlist_votes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `wantlist_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `achievements_slug_unique` (`slug`);

--
-- Indexes for table `ai_generations`
--
ALTER TABLE `ai_generations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ai_generations_user_id_type_index` (`user_id`,`type`),
  ADD KEY `ai_generations_status_created_at_index` (`status`,`created_at`),
  ADD KEY `ai_gen_user_type_idx` (`user_id`,`type`);

--
-- Indexes for table `annotations`
--
ALTER TABLE `annotations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `annotations_user_id_foreign` (`user_id`),
  ADD KEY `annotations_article_id_foreign` (`article_id`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `articles_slug_unique` (`slug`),
  ADD KEY `articles_category_index` (`category`),
  ADD KEY `articles_view_count_index` (`view_count`),
  ADD KEY `articles_trending_score_index` (`trending_score`),
  ADD KEY `articles_status_index` (`status`),
  ADD KEY `articles_category_status_idx` (`category`,`status`),
  ADD KEY `articles_status_date_idx` (`status`,`created_at`),
  ADD KEY `articles_user_status_idx` (`user_id`,`status`),
  ADD KEY `articles_master_id_foreign` (`master_id`);

--
-- Indexes for table `article_analyses`
--
ALTER TABLE `article_analyses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `article_analyses_article_id_unique` (`article_id`);

--
-- Indexes for table `article_gear`
--
ALTER TABLE `article_gear`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `article_gear_article_id_gear_id_unique` (`article_id`,`gear_id`),
  ADD KEY `article_gear_gear_id_foreign` (`gear_id`);

--
-- Indexes for table `article_relationships`
--
ALTER TABLE `article_relationships`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `art_rel_unique` (`source_id`,`target_id`,`type`),
  ADD KEY `article_relationships_target_id_foreign` (`target_id`);

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artists_article_id_foreign` (`article_id`),
  ADD KEY `artists_spotify_id_index` (`spotify_id`);

--
-- Indexes for table `artist_collaborations`
--
ALTER TABLE `artist_collaborations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artist_collaborations_artist2_id_foreign` (`artist2_id`),
  ADD KEY `collab_artists_idx` (`artist1_id`,`artist2_id`);

--
-- Indexes for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bookmarks_user_id_article_id_unique` (`user_id`,`article_id`),
  ADD KEY `bookmarks_article_id_foreign` (`article_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_user_id_foreign` (`user_id`),
  ADD KEY `comments_article_id_foreign` (`article_id`),
  ADD KEY `comments_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `crate_articles`
--
ALTER TABLE `crate_articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `crate_articles_crate_id_article_id_unique` (`crate_id`,`article_id`),
  ADD KEY `crate_articles_article_id_foreign` (`article_id`);

--
-- Indexes for table `crate_collaborators`
--
ALTER TABLE `crate_collaborators`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `crate_collaborators_crate_id_user_id_unique` (`crate_id`,`user_id`),
  ADD KEY `crate_collaborators_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `followers_user_id_followable_id_followable_type_unique` (`user_id`,`followable_id`,`followable_type`),
  ADD KEY `followers_followable_type_followable_id_index` (`followable_type`,`followable_id`);

--
-- Indexes for table `gears`
--
ALTER TABLE `gears`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gears_slug_unique` (`slug`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `genres_slug_unique` (`slug`),
  ADD KEY `genres_article_id_foreign` (`article_id`),
  ADD KEY `genres_parent_genre_id_foreign` (`parent_genre_id`);

--
-- Indexes for table `genre_relationships`
--
ALTER TABLE `genre_relationships`
  ADD PRIMARY KEY (`id`),
  ADD KEY `genre_relationships_source_genre_id_foreign` (`source_genre_id`),
  ADD KEY `genre_relationships_target_genre_id_foreign` (`target_genre_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `knowledge_graph_links`
--
ALTER TABLE `knowledge_graph_links`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `knowledge_graph_links_source_id_target_id_unique` (`source_id`,`target_id`),
  ADD KEY `knowledge_graph_links_target_id_foreign` (`target_id`);

--
-- Indexes for table `knowledge_wantlist`
--
ALTER TABLE `knowledge_wantlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `knowledge_wantlist_user_id_foreign` (`user_id`),
  ADD KEY `knowledge_wantlist_status_index` (`status`),
  ADD KEY `knowledge_wantlist_votes_index` (`votes`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `playlists`
--
ALTER TABLE `playlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `playlists_article_id_foreign` (`article_id`);

--
-- Indexes for table `playlist_tracks`
--
ALTER TABLE `playlist_tracks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `playlist_tracks_playlist_id_foreign` (`playlist_id`),
  ADD KEY `playlist_tracks_song_id_foreign` (`song_id`);

--
-- Indexes for table `revisions`
--
ALTER TABLE `revisions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `revisions_article_id_foreign` (`article_id`),
  ADD KEY `revisions_user_id_foreign` (`user_id`),
  ADD KEY `revisions_status_index` (`status`),
  ADD KEY `revisions_moderated_by_foreign` (`moderated_by`);

--
-- Indexes for table `search_logs`
--
ALTER TABLE `search_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `search_logs_user_id_foreign` (`user_id`),
  ADD KEY `search_logs_query_created_at_index` (`query`,`created_at`),
  ADD KEY `search_logs_created_at_index` (`created_at`),
  ADD KEY `search_logs_created_idx` (`created_at`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `songs_article_id_foreign` (`article_id`),
  ADD KEY `songs_artist_id_foreign` (`artist_id`),
  ADD KEY `songs_genre_id_foreign` (`genre_id`),
  ADD KEY `songs_spotify_id_index` (`spotify_id`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `terms_article_id_foreign` (`article_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Indexes for table `user_achievements`
--
ALTER TABLE `user_achievements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_achievements_user_id_achievement_id_unique` (`user_id`,`achievement_id`),
  ADD KEY `user_achievements_achievement_id_foreign` (`achievement_id`),
  ADD KEY `user_achievements_earned_at_index` (`earned_at`),
  ADD KEY `user_ach_earned_idx` (`user_id`,`earned_at`);

--
-- Indexes for table `user_crates`
--
ALTER TABLE `user_crates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_crates_slug_unique` (`slug`),
  ADD KEY `user_crates_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_streaks`
--
ALTER TABLE `user_streaks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_streaks_user_id_type_unique` (`user_id`,`type`);

--
-- Indexes for table `views`
--
ALTER TABLE `views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `views_user_id_foreign` (`user_id`),
  ADD KEY `views_article_id_created_at_index` (`article_id`,`created_at`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `votes_user_id_votable_type_votable_id_unique` (`user_id`,`votable_type`,`votable_id`),
  ADD KEY `votes_votable_type_votable_id_index` (`votable_type`,`votable_id`);

--
-- Indexes for table `wantlist_votes`
--
ALTER TABLE `wantlist_votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wantlist_votes_user_id_wantlist_id_unique` (`user_id`,`wantlist_id`),
  ADD KEY `wantlist_votes_wantlist_id_foreign` (`wantlist_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `achievements`
--
ALTER TABLE `achievements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `ai_generations`
--
ALTER TABLE `ai_generations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `annotations`
--
ALTER TABLE `annotations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `article_analyses`
--
ALTER TABLE `article_analyses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `article_gear`
--
ALTER TABLE `article_gear`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `article_relationships`
--
ALTER TABLE `article_relationships`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `artist_collaborations`
--
ALTER TABLE `artist_collaborations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `crate_articles`
--
ALTER TABLE `crate_articles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `crate_collaborators`
--
ALTER TABLE `crate_collaborators`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gears`
--
ALTER TABLE `gears`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `genre_relationships`
--
ALTER TABLE `genre_relationships`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `knowledge_graph_links`
--
ALTER TABLE `knowledge_graph_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `knowledge_wantlist`
--
ALTER TABLE `knowledge_wantlist`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `playlists`
--
ALTER TABLE `playlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `playlist_tracks`
--
ALTER TABLE `playlist_tracks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `revisions`
--
ALTER TABLE `revisions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `search_logs`
--
ALTER TABLE `search_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_achievements`
--
ALTER TABLE `user_achievements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_crates`
--
ALTER TABLE `user_crates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_streaks`
--
ALTER TABLE `user_streaks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `views`
--
ALTER TABLE `views`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=376;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `wantlist_votes`
--
ALTER TABLE `wantlist_votes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ai_generations`
--
ALTER TABLE `ai_generations`
  ADD CONSTRAINT `ai_generations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `annotations`
--
ALTER TABLE `annotations`
  ADD CONSTRAINT `annotations_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `annotations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_master_id_foreign` FOREIGN KEY (`master_id`) REFERENCES `articles` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `articles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `article_analyses`
--
ALTER TABLE `article_analyses`
  ADD CONSTRAINT `article_analyses_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `article_gear`
--
ALTER TABLE `article_gear`
  ADD CONSTRAINT `article_gear_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `article_gear_gear_id_foreign` FOREIGN KEY (`gear_id`) REFERENCES `gears` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `article_relationships`
--
ALTER TABLE `article_relationships`
  ADD CONSTRAINT `article_relationships_source_id_foreign` FOREIGN KEY (`source_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `article_relationships_target_id_foreign` FOREIGN KEY (`target_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `artists`
--
ALTER TABLE `artists`
  ADD CONSTRAINT `artists_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `artist_collaborations`
--
ALTER TABLE `artist_collaborations`
  ADD CONSTRAINT `artist_collaborations_artist1_id_foreign` FOREIGN KEY (`artist1_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `artist_collaborations_artist2_id_foreign` FOREIGN KEY (`artist2_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD CONSTRAINT `bookmarks_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookmarks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `crate_articles`
--
ALTER TABLE `crate_articles`
  ADD CONSTRAINT `crate_articles_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `crate_articles_crate_id_foreign` FOREIGN KEY (`crate_id`) REFERENCES `user_crates` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `crate_collaborators`
--
ALTER TABLE `crate_collaborators`
  ADD CONSTRAINT `crate_collaborators_crate_id_foreign` FOREIGN KEY (`crate_id`) REFERENCES `user_crates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `crate_collaborators_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `followers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `genres`
--
ALTER TABLE `genres`
  ADD CONSTRAINT `genres_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `genres_parent_genre_id_foreign` FOREIGN KEY (`parent_genre_id`) REFERENCES `genres` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `genre_relationships`
--
ALTER TABLE `genre_relationships`
  ADD CONSTRAINT `genre_relationships_source_genre_id_foreign` FOREIGN KEY (`source_genre_id`) REFERENCES `genres` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `genre_relationships_target_genre_id_foreign` FOREIGN KEY (`target_genre_id`) REFERENCES `genres` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `knowledge_graph_links`
--
ALTER TABLE `knowledge_graph_links`
  ADD CONSTRAINT `knowledge_graph_links_source_id_foreign` FOREIGN KEY (`source_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `knowledge_graph_links_target_id_foreign` FOREIGN KEY (`target_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `knowledge_wantlist`
--
ALTER TABLE `knowledge_wantlist`
  ADD CONSTRAINT `knowledge_wantlist_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `playlists`
--
ALTER TABLE `playlists`
  ADD CONSTRAINT `playlists_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `playlist_tracks`
--
ALTER TABLE `playlist_tracks`
  ADD CONSTRAINT `playlist_tracks_playlist_id_foreign` FOREIGN KEY (`playlist_id`) REFERENCES `playlists` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `playlist_tracks_song_id_foreign` FOREIGN KEY (`song_id`) REFERENCES `songs` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `revisions`
--
ALTER TABLE `revisions`
  ADD CONSTRAINT `revisions_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `revisions_moderated_by_foreign` FOREIGN KEY (`moderated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `revisions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `search_logs`
--
ALTER TABLE `search_logs`
  ADD CONSTRAINT `search_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `songs`
--
ALTER TABLE `songs`
  ADD CONSTRAINT `songs_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `songs_artist_id_foreign` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `songs_genre_id_foreign` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `terms`
--
ALTER TABLE `terms`
  ADD CONSTRAINT `terms_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_achievements`
--
ALTER TABLE `user_achievements`
  ADD CONSTRAINT `user_achievements_achievement_id_foreign` FOREIGN KEY (`achievement_id`) REFERENCES `achievements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_achievements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_crates`
--
ALTER TABLE `user_crates`
  ADD CONSTRAINT `user_crates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_streaks`
--
ALTER TABLE `user_streaks`
  ADD CONSTRAINT `user_streaks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `views`
--
ALTER TABLE `views`
  ADD CONSTRAINT `views_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `views_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wantlist_votes`
--
ALTER TABLE `wantlist_votes`
  ADD CONSTRAINT `wantlist_votes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wantlist_votes_wantlist_id_foreign` FOREIGN KEY (`wantlist_id`) REFERENCES `knowledge_wantlist` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
