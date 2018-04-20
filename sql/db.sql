-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2018 at 12:45 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tpo`
--

-- --------------------------------------------------------

--
-- Table structure for table `del_predmetnika`
--

CREATE TABLE `del_predmetnika` (
  `ID_DELPREDMETNIKA` int(11) NOT NULL,
  `NAZIV_DELAPREDMETNIKA` char(50) COLLATE utf8_slovenian_ci NOT NULL,
  `SKUPNOSTEVILOKT` int(11) NOT NULL,
  `TIP` char(2) COLLATE utf8_slovenian_ci NOT NULL,
  `AKTIVNOST` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `del_predmetnika`
--

INSERT INTO `del_predmetnika` (`ID_DELPREDMETNIKA`, `NAZIV_DELAPREDMETNIKA`, `SKUPNOSTEVILOKT`, `TIP`, `AKTIVNOST`) VALUES
  (1, 'Razvoj programske opreme', 18, 'm', 1),
  (2, 'Informacijski sistemi', 18, 'm', 1),
  (3, 'Obvezni predmet', 6, 'o', 1),
  (4, 'Strokovni izbirni predmet', 6, 'st', 1),
  (5, 'Splosno izbirni predmet', 6, 'sp', 1);

-- --------------------------------------------------------

--
-- Table structure for table `drzava`
--

CREATE TABLE `drzava` (
  `ID_DRZAVA` int(11) NOT NULL,
  `DVOMESTNAKODA` char(2) COLLATE utf8_slovenian_ci NOT NULL,
  `TRIMESTNAKODA` char(3) COLLATE utf8_slovenian_ci NOT NULL,
  `ISONAZIV` char(50) COLLATE utf8_slovenian_ci NOT NULL,
  `SLOVENSKINAZIV` char(50) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `OPOMBA` char(200) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `AKTIVNOST` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `drzava`
--

INSERT INTO `drzava` (`ID_DRZAVA`, `DVOMESTNAKODA`, `TRIMESTNAKODA`, `ISONAZIV`, `SLOVENSKINAZIV`, `OPOMBA`, `AKTIVNOST`) VALUES
  (4, 'AF', 'AFG', 'Afghanistan', 'Afganistan', NULL, 1),
  (8, 'AL', 'ALB', 'Albania', 'Albanija', NULL, 1),
  (10, 'AQ', 'ATA', 'Antarctica', 'Antarktika', NULL, 1),
  (12, 'DZ', 'DZA', 'Algeria', 'Alžirija', NULL, 1),
  (16, 'AS', 'ASM', 'American Samoa', 'Ameriška Samoa', NULL, 1),
  (20, 'AD', 'AND', 'Andorra', 'Andora', NULL, 1),
  (24, 'AO', 'AGO', 'Angola', 'Angola', NULL, 1),
  (28, 'AG', 'ATG', 'Antigua and Barbuda', 'Antigva in Barbuda', NULL, 1),
  (31, 'AZ', 'AZE', 'Azerbaijan', 'Azerbajdžan', NULL, 1),
  (32, 'AR', 'ARG', 'Argentina', 'Argenitna', NULL, 1),
  (36, 'AU', 'AUS', 'Australia', 'Avstralija', NULL, 1),
  (40, 'AT', 'AUT', 'Austria', 'Avstrija', NULL, 1),
  (44, 'BS', 'BHS', 'Bahamas', 'Bahami', NULL, 1),
  (48, 'BH', 'BHR', 'Bahrain', 'Bahrajn', NULL, 1),
  (50, 'BD', 'BGD', 'Bangladesh', 'Bangladeš', NULL, 1),
  (51, 'AM', 'ARM', 'Armenia', 'Armenija', NULL, 1),
  (52, 'BB', 'BRB', 'Barbados', 'Barbados', NULL, 1),
  (56, 'BE', 'BEL', 'Belgium', 'Belgija', NULL, 1),
  (60, 'BM', 'BMU', 'Bermuda', 'Bermudi', NULL, 1),
  (64, 'BT', 'BTN', 'Bhutan', 'Butan', NULL, 1),
  (68, 'BO', 'BOL', 'Bolivia, Plurinational State of', 'Bolivija', NULL, 1),
  (70, 'BA', 'BIH', 'Bosnia and Herzegovina', 'Bosna in Hercegovina', NULL, 1),
  (72, 'BW', 'BWA', 'Botswana', 'Bocvana', NULL, 1),
  (74, 'BV', 'BVT', 'Bouvet Island', 'Bouvetov otok', NULL, 1),
  (76, 'BR', 'BRA', 'Brazil', 'Brazilija', NULL, 1),
  (84, 'BZ', 'BLZ', 'Belize', 'Belize', NULL, 1),
  (86, 'IO', 'IOT', 'British Indian Ocean Territory', 'Britansko ozemlje v Indijskem oceanu', NULL, 1),
  (90, 'SB', 'SLB', 'Solomon Islands', 'Solomonovi otoki', NULL, 1),
  (92, 'VG', 'VGB', 'Virgin Islands, British', 'Britanski Deviški otoki', NULL, 1),
  (96, 'BN', 'BRN', 'Brunei Darussalam', 'Brunej', NULL, 1),
  (100, 'BG', 'BGR', 'Bulgaria', 'Bolgarija', NULL, 1),
  (104, 'MM', 'MMR', 'Myanmar', 'Mjanmar', NULL, 1),
  (108, 'BI', 'BDI', 'Burundi', 'Burundi', NULL, 1),
  (112, 'BY', 'BLR', 'Belarus', 'Belorusija', NULL, 1),
  (116, 'KH', 'KHM', 'Cambodia', 'Kambodža', NULL, 1),
  (120, 'CM', 'CMR', 'Cameroon', 'Kamerun', NULL, 1),
  (124, 'CA', 'CAN', 'Canada', 'Kanada', NULL, 1),
  (132, 'CV', 'CPV', 'Cape Verde', 'Kapverdski otoki (Zelenortski otoki)', NULL, 1),
  (136, 'KY', 'CYM', 'Cayman Islands', 'Kajmanski otoki', NULL, 1),
  (140, 'CF', 'CAF', 'Central African Republic', 'Srednjeafriška republika', NULL, 1),
  (144, 'LK', 'LKA', 'Sri Lanka', 'Šri Lanka', NULL, 1),
  (148, 'TD', 'TCD', 'Chad', 'Čad', NULL, 1),
  (152, 'CL', 'CHL', 'Chile', 'Čile', NULL, 1),
  (156, 'CN', 'CHN', 'China', 'Kitajska', NULL, 1),
  (158, 'TW', 'TWN', 'Taiwan, Province of China', 'Tajvan', NULL, 1),
  (162, 'CX', 'CXR', 'Christmas Island', 'Božični otok', NULL, 1),
  (166, 'CC', 'CCK', 'Cocos (Keeling) Islands', 'Kokosovi in Keelingovi otoki', NULL, 1),
  (170, 'CO', 'COL', 'Colombia', 'Kolumbija', NULL, 1),
  (174, 'KM', 'COM', 'Comoros', 'Komori', NULL, 1),
  (175, 'YT', 'MYT', 'Mayotte', 'Francoska skupnost Mejot', NULL, 1),
  (178, 'CG', 'COG', 'Congo', 'Kongo', NULL, 1),
  (180, 'CD', 'COD', 'Congo, the Democratic Republic of the', 'Demokratična republika Kongo', NULL, 1),
  (184, 'CK', 'COK', 'Cook Islands', 'Cookovi otoki', NULL, 1),
  (188, 'CR', 'CRI', 'Costa Rica', 'Kostarika', NULL, 1),
  (191, 'HR', 'HRV', 'Croatia', 'Hrvaška', NULL, 1),
  (192, 'CU', 'CUB', 'Cuba', 'Kuba', NULL, 1),
  (196, 'CY', 'CYP', 'Cyprus', 'Ciper', NULL, 1),
  (203, 'CZ', 'CZE', 'Czech Republic', 'Češka', NULL, 1),
  (204, 'BJ', 'BEN', 'Benin', 'Benin', NULL, 1),
  (208, 'DK', 'DNK', 'Denmark', 'Danska', NULL, 1),
  (212, 'DM', 'DMA', 'Dominica', 'Dominika', NULL, 1),
  (214, 'DO', 'DOM', 'Dominican Republic', 'Dominikanska republika', NULL, 1),
  (218, 'EC', 'ECU', 'Ecuador', 'Ekvador', NULL, 1),
  (222, 'SV', 'SLV', 'El Salvador', 'Salvador', NULL, 1),
  (226, 'GQ', 'GNQ', 'Equatorial Guinea', 'Ekvatorialna Gvineja', NULL, 1),
  (231, 'ET', 'ETH', 'Ethiopia', 'Etiopija', NULL, 1),
  (232, 'ER', 'ERI', 'Eritrea', 'Eritreja', NULL, 1),
  (233, 'EE', 'EST', 'Estonia', 'Estonija', NULL, 1),
  (234, 'FK', 'FRO', 'Falkland Islands (Malvinas)', 'Falkalndski otoki', NULL, 1),
  (238, 'FO', 'FLK', 'Faroe Islands', 'Ferski otoki', NULL, 1),
  (239, 'GS', 'SGS', 'South Georgia and the South Sandwich Islands', 'Južna Georgia in Južni Sandwichevi otoki', NULL, 1),
  (242, 'FJ', 'FJI', 'Fiji', 'Fidži', NULL, 1),
  (246, 'FI', 'FIN', 'Finland', 'Finska', NULL, 1),
  (248, 'AX', 'ALA', 'Ålland Islands', 'Alandski otoki', NULL, 1),
  (250, 'FR', 'FRA', 'France', 'Francija', NULL, 1),
  (254, 'GF', 'GUF', 'French Guiana', 'Francoska Gvajana', NULL, 1),
  (258, 'PF', 'PYF', 'French Polynesia', 'Francoska Polinezija', NULL, 1),
  (260, 'TF', 'ATF', 'French Southern Territories', 'Francoska južna ozemlja', NULL, 1),
  (262, 'DJ', 'DJI', 'Djibouti', 'Džibuti', NULL, 1),
  (266, 'GA', 'GAB', 'Gabon', 'Gabon', NULL, 1),
  (268, 'GE', 'GEO', 'Georgia', 'Gruzija', NULL, 1),
  (270, 'GM', 'GMB', 'Gambia', 'Gambija', NULL, 1),
  (275, 'PS', 'PSE', 'Palestinian Territory, Occupied', 'Palestina', NULL, 1),
  (276, 'DE', 'DEU', 'Germany', 'Nemčija', NULL, 1),
  (288, 'GH', 'GHA', 'Ghana', 'Gana', NULL, 1),
  (292, 'GI', 'GIB', 'Gibraltar', 'Gibraltar', NULL, 1),
  (296, 'KI', 'KIR', 'Kiribati', 'Kiribati', NULL, 1),
  (300, 'GR', 'GRC', 'Greece', 'Grčija', NULL, 1),
  (304, 'GL', 'GRL', 'Greenland', 'Grenlandija', NULL, 1),
  (308, 'GD', 'GRD', 'Grenada', 'Grenada', NULL, 1),
  (312, 'GP', 'GLP', 'Guadeloupe', 'Guadeloupe', NULL, 1),
  (316, 'GU', 'GUM', 'Guam', 'Guam', NULL, 1),
  (320, 'GT', 'GTM', 'Guatemala', 'Gvatemala', NULL, 1),
  (324, 'GN', 'GIN', 'Guinea', 'Gvineja', NULL, 1),
  (328, 'GY', 'GUY', 'Guyana', 'Gvajana', NULL, 1),
  (332, 'HT', 'HTI', 'Haiti', 'Haiti', NULL, 1),
  (334, 'HM', 'HMD', 'Heard Island and McDonald Islands', 'Otok Heard in otočje McDonald', NULL, 1),
  (336, 'VA', 'VAT', 'Holy See (Vatican City State)', 'Vatikan', NULL, 1),
  (340, 'HN', 'HND', 'Honduras', 'Honduras', NULL, 1),
  (344, 'HK', 'HKG', 'Hong Kong', 'Hong Kong', NULL, 1),
  (348, 'HU', 'HUN', 'Hungary', 'Madžarska', NULL, 1),
  (352, 'IS', 'ISL', 'Iceland', 'Islandija', NULL, 1),
  (356, 'IN', 'IND', 'India', 'Indija', NULL, 1),
  (360, 'ID', 'IDN', 'Indonesia', 'Indonezija', NULL, 1),
  (364, 'IR', 'IRN', 'Iran, Islamic Republic of', 'Iran', NULL, 1),
  (368, 'IQ', 'IRQ', 'Iraq', 'Irak', NULL, 1),
  (372, 'IE', 'IRL', 'Ireland', 'Irska', NULL, 1),
  (376, 'IL', 'ISR', 'Israel', 'Izrael', NULL, 1),
  (380, 'IT', 'ITA', 'Italy', 'Italija', NULL, 1),
  (384, 'CI', 'CIV', 'Côte d\'Ivoire', 'Slonokoščena obala', NULL, 1),
  (388, 'JM', 'JAM', 'Jamaica', 'Jamajka', NULL, 1),
  (392, 'JP', 'JPN', 'Japan', 'Japonska', NULL, 1),
  (398, 'KZ', 'KAZ', 'Kazakhstan', 'Kazahstan', NULL, 1),
  (400, 'JO', 'JOR', 'Jordan', 'Jordanija', NULL, 1),
  (404, 'KE', 'KEN', 'Kenya', 'Kenija', NULL, 1),
  (408, 'KP', 'PRK', 'Korea, Democratic People\'s Republic of', 'Severna Koreja', NULL, 1),
  (410, 'KR', 'KOR', 'Korea, Republic of', 'Južna Koreja', NULL, 1),
  (414, 'KW', 'KWT', 'Kuwait', 'Kuvajt', NULL, 1),
  (417, 'KG', 'KGZ', 'Kyrgyzstan', 'Kirgizistan (Kirgizija)', NULL, 1),
  (418, 'LA', 'LAO', 'Lao People\'s Democratic Republic', 'Laos', NULL, 1),
  (422, 'LB', 'LBN', 'Lebanon', 'Libanon', NULL, 1),
  (426, 'LS', 'LSO', 'Lesotho', 'Lesoto', NULL, 1),
  (428, 'LV', 'LVA', 'Latvia', 'Latvija', NULL, 1),
  (430, 'LR', 'LBR', 'Liberia', 'Liberija', NULL, 1),
  (434, 'LY', 'LBY', 'Libya', 'Libija', NULL, 1),
  (438, 'LI', 'LIE', 'Liechtenstein', 'Lihtenštajn', NULL, 1),
  (440, 'LT', 'LTU', 'Lithuania', 'Litva', NULL, 1),
  (442, 'LU', 'LUX', 'Luxembourg', 'Luksemburg', NULL, 1),
  (446, 'MO', 'MAC', 'Macao', 'Makao', NULL, 1),
  (450, 'MG', 'MDG', 'Madagascar', 'Madagaskar', NULL, 1),
  (454, 'MW', 'MWI', 'Malawi', 'Malavi', NULL, 1),
  (458, 'MY', 'MYS', 'Malaysia', 'Malezija', NULL, 1),
  (462, 'MV', 'MDV', 'Maldives', 'Maldivi', NULL, 1),
  (466, 'ML', 'MLI', 'Mali', 'Mali', NULL, 1),
  (470, 'MT', 'MLT', 'Malta', 'Malta', NULL, 1),
  (474, 'MQ', 'MTQ', 'Martinique', 'Martinik', NULL, 1),
  (478, 'MR', 'MRT', 'Mauritania', 'Mavretanija', NULL, 1),
  (480, 'MU', 'MUS', 'Mauritius', 'Mauricius (Moris)', NULL, 1),
  (484, 'MX', 'MEX', 'Mexico', 'Mehika', NULL, 1),
  (492, 'MC', 'MCO', 'Monaco', 'Monako', NULL, 1),
  (496, 'MN', 'MNG', 'Mongolia', 'Mongolija', NULL, 1),
  (498, 'MD', 'MDA', 'Moldova, Republic of', 'Moldavija', NULL, 1),
  (499, 'ME', 'MNE', 'Montenegro', 'Črna Gora', NULL, 1),
  (500, 'MS', 'MSR', 'Montserrat', 'Montserat', NULL, 1),
  (504, 'MA', 'MAR', 'Morocco', 'Maroko', NULL, 1),
  (508, 'MZ', 'MOZ', 'Mozambique', 'Mozambik', NULL, 1),
  (512, 'OM', 'OMN', 'Oman', 'Oman', NULL, 1),
  (516, 'NA', 'NAM', 'Namibia', 'Namibija', NULL, 1),
  (520, 'NR', 'NRU', 'Nauru', 'Nauru', NULL, 1),
  (524, 'NP', 'NPL', 'Nepal', 'Nepal', NULL, 1),
  (528, 'NL', 'NLD', 'Netherlands', 'Nizozemska', NULL, 1),
  (531, 'CW', 'CUW', 'Curaçao', 'Kurasao', NULL, 1),
  (533, 'AW', 'ABW', 'Aruba', 'Aruba', NULL, 1),
  (534, 'SX', 'SXM', 'Sint Maarten (Dutch part)', 'Otok svetega.Martina (Nizozemska)', NULL, 1),
  (535, 'BQ', 'BES', 'Bonaire, Sint Eustatius and Saba', 'Otočje Bonaire, Sv. Eustatij in Saba', NULL, 1),
  (540, 'NC', 'NCL', 'New Caledonia', 'Nova Kaledonija', NULL, 1),
  (548, 'VU', 'VUT', 'Vanuatu', 'Republika Vanuatu', NULL, 1),
  (554, 'NZ', 'NZL', 'New Zealand', 'Nova Zelandija', NULL, 1),
  (558, 'NI', 'NIC', 'Nicaragua', 'Nikaragva', NULL, 1),
  (562, 'NE', 'NER', 'Niger', 'Niger', NULL, 1),
  (566, 'NG', 'NGA', 'Nigeria', 'Nigerija', NULL, 1),
  (570, 'NU', 'NIU', 'Niue', 'Niu', NULL, 1),
  (574, 'NF', 'NFK', 'Norfolk Island', 'Otok Norflok', NULL, 1),
  (578, 'NO', 'NOR', 'Norway', 'Norveška', NULL, 1),
  (580, 'MP', 'MNP', 'Northern Mariana Islands', 'Severni Marianski otoki', NULL, 1),
  (581, 'UM', 'UMI', 'United States Minor Outlying Islands', 'ZDA zunanji otoki', NULL, 1),
  (583, 'FM', 'FSM', 'Micronesia, Federated States of', 'Mikronezija', NULL, 1),
  (584, 'MH', 'MHL', 'Marshall Islands', 'Maršalovi otoki', NULL, 1),
  (585, 'PW', 'PLW', 'Palau', 'Palau', NULL, 1),
  (586, 'PK', 'PAK', 'Pakistan', 'Pakistan', NULL, 1),
  (591, 'PA', 'PAN', 'Panama', 'Panama', NULL, 1),
  (598, 'PG', 'PNG', 'Papua New Guinea', 'Papua Nova Gvineja', NULL, 1),
  (600, 'PY', 'PRY', 'Paraguay', 'Paragvaj', NULL, 1),
  (604, 'PE', 'PER', 'Peru', 'Peru', NULL, 1),
  (608, 'PH', 'PHL', 'Philippines', 'Filipini', NULL, 1),
  (612, 'PN', 'PCN', 'Pitcairn', 'Pitcairnovi otoki', NULL, 1),
  (616, 'PL', 'POL', 'Poland', 'Poljska', NULL, 1),
  (620, 'PT', 'PRT', 'Portugal', 'Portugalska', NULL, 1),
  (624, 'GW', 'GNB', 'Guinea-Bissau', 'Gvineja-Bissau', NULL, 1),
  (626, 'TL', 'TLS', 'Timor-Leste', 'Vzhodni Timor', NULL, 1),
  (630, 'PR', 'PRI', 'Puerto Rico', 'Portoriko', NULL, 1),
  (634, 'QA', 'QAT', 'Qatar', 'Katar', NULL, 1),
  (638, 'RE', 'REU', 'Réunion', 'Francoska skupnost Reunion', NULL, 1),
  (642, 'RO', 'ROU', 'Romania', 'Romunija', NULL, 1),
  (643, 'RU', 'RUS', 'Russian Federation', 'Ruska federacija', NULL, 1),
  (646, 'RW', 'RWA', 'Rwanda', 'Ruanda', NULL, 1),
  (652, 'BL', 'BLM', 'Saint Barthélemy', 'Sveti Bartolomej', NULL, 1),
  (654, 'SH', 'SHN', 'Saint Helena, Ascension and Tristan da Cunha', 'Sveta Helena', NULL, 1),
  (659, 'KN', 'KNA', 'Saint Kitts and Nevis', 'Sveti Kits in Nevis', NULL, 1),
  (660, 'AI', 'AIA', 'Anguilla', 'Angvila', NULL, 1),
  (662, 'LC', 'LCA', 'Saint Lucia', 'Sveta Lucija', NULL, 1),
  (663, 'MF', 'MAF', 'Saint Martin (French part)', 'Otok svetega Martina', NULL, 1),
  (666, 'PM', 'SPM', 'Saint Pierre and Miquelon', 'Sveta Pierre in Miquelon', NULL, 1),
  (670, 'VC', 'VCT', 'Saint Vincent and the Grenadines', 'Sveti Vincent in Grenadini', NULL, 1),
  (674, 'SM', 'SMR', 'San Marino', 'San Marino', NULL, 1),
  (678, 'ST', 'STP', 'Sao Tome and Principe', 'Sao Tome in Principe', NULL, 1),
  (682, 'SA', 'SAU', 'Saudi Arabia', 'Savdska Arabija', NULL, 1),
  (686, 'SN', 'SEN', 'Senegal', 'Senegal', NULL, 1),
  (688, 'RS', 'SRB', 'Serbia', 'Srbija', NULL, 1),
  (690, 'SC', 'SYC', 'Seychelles', 'Sejšeli', NULL, 1),
  (694, 'SL', 'SLE', 'Sierra Leone', 'Siera Leone', NULL, 1),
  (702, 'SG', 'SGP', 'Singapore', 'Singapur', NULL, 1),
  (703, 'SK', 'SVK', 'Slovakia', 'Slovaška', NULL, 1),
  (704, 'VN', 'VNM', 'Viet Nam', 'Vietnam', NULL, 1),
  (705, 'SI', 'SVN', 'Slovenia', 'Slovenija', NULL, 1),
  (706, 'SO', 'SOM', 'Somalia', 'Somalija', NULL, 1),
  (710, 'ZA', 'ZAF', 'South Africa', 'Južna afrika', NULL, 1),
  (716, 'ZW', 'ZWE', 'Zimbabwe', 'Zimbabve', NULL, 1),
  (724, 'ES', 'ESP', 'Spain', 'Španija', NULL, 1),
  (728, 'SS', 'SSD', 'South Sudan', 'Južni Sudan', NULL, 1),
  (729, 'SD', 'SDN', 'Sudan', 'Sudan', NULL, 1),
  (732, 'EH', 'ESH', 'Western Sahara', 'Zahodna Sahara', NULL, 1),
  (740, 'SR', 'SUR', 'Suriname', 'Surinam', NULL, 1),
  (744, 'SJ', 'SJM', 'Svalbard and Jan Mayen', 'Svalbard in Jan Majen', NULL, 1),
  (748, 'SZ', 'SWZ', 'Swaziland', 'Svazi', NULL, 1),
  (752, 'SE', 'SWE', 'Sweden', 'Švedska', NULL, 1),
  (756, 'CH', 'CHE', 'Switzerland', 'Švica', NULL, 1),
  (760, 'SY', 'SYR', 'Syrian Arab Republic', 'Sirija', NULL, 1),
  (762, 'TJ', 'TJK', 'Tajikistan', 'Tadžikistan', NULL, 1),
  (764, 'TH', 'THA', 'Thailand', 'Tajska', NULL, 1),
  (768, 'TG', 'TGO', 'Togo', 'Togo', NULL, 1),
  (772, 'TK', 'TKL', 'Tokelau', 'Tokelau', NULL, 1),
  (776, 'TO', 'TON', 'Tonga', 'Tonga', NULL, 1),
  (780, 'TT', 'TTO', 'Trinidad and Tobago', 'Trinidad in Tobago', NULL, 1),
  (784, 'AE', 'ARE', 'United Arab Emirates', 'Združeni Arabski Emirati', NULL, 1),
  (788, 'TN', 'TUN', 'Tunisia', 'Tunizija', NULL, 1),
  (792, 'TR', 'TUR', 'Turkey', 'Turčija', NULL, 1),
  (795, 'TM', 'TKM', 'Turkmenistan', 'Turkmenistan', NULL, 1),
  (796, 'TC', 'TCA', 'Turks and Caicos Islands', 'Tirški in Kajkoški otoki', NULL, 1),
  (798, 'TV', 'TUV', 'Tuvalu', 'Tuvalu', NULL, 1),
  (800, 'UG', 'UGA', 'Uganda', 'Uganda', NULL, 1),
  (804, 'UA', 'UKR', 'Ukraine', 'Ukrajina', NULL, 1),
  (807, 'MK', 'MKD', 'Macedonia, the former Yugoslav Republic of', 'Makedonija', NULL, 1),
  (818, 'EG', 'EGY', 'Egypt', 'Egipt', NULL, 1),
  (826, 'GB', 'GBR', 'United Kingdom', 'Velika Britanija', NULL, 1),
  (831, 'GG', 'GGY', 'Guernsey', 'Otok Guernsey', NULL, 1),
  (832, 'JE', 'JEY', 'Jersey', 'Otok Jersey', NULL, 1),
  (833, 'IM', 'IMN', 'Isle of Man', 'Otok Man', NULL, 1),
  (834, 'TZ', 'TZA', 'Tanzania, United Republic of', 'Tanzanija', NULL, 1),
  (840, 'US', 'USA', 'United States', 'Združene države Amerike', NULL, 1),
  (850, 'VI', 'VIR', 'Virgin Islands, U.S.', 'Ameriški Deviški otoki', NULL, 1),
  (854, 'BF', 'BFA', 'Burkina Faso', 'Burkina Faso', NULL, 1),
  (858, 'UY', 'URY', 'Uruguay', 'Urugvaj', NULL, 1),
  (860, 'UZ', 'UZB', 'Uzbekistan', 'Uzbekistan', NULL, 1),
  (862, 'VE', 'VEN', 'Venezuela, Bolivarian Republic of', 'Venezuela', NULL, 1),
  (876, 'WF', 'WLF', 'Wallis and Futuna', 'Otočje Valis in Futuna', NULL, 1),
  (882, 'WS', 'WSM', 'Samoa', 'Samoa', NULL, 1),
  (887, 'YE', 'YEM', 'Yemen', 'Jemen', NULL, 1),
  (894, 'ZM', 'ZMB', 'Zambia', 'Zambija', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `izpit`
--

CREATE TABLE `izpit` (
  `ID_IZPIT` int(11) NOT NULL,
  `ID_PRIJAVA` int(11) DEFAULT NULL,
  `OCENA_IZPITA` int(11) DEFAULT NULL,
  `AKTIVNOST` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `izvedba_predmeta`
--

CREATE TABLE `izvedba_predmeta` (
  `ID_IZVEDBA` int(11) NOT NULL,
  `ID_STUD_LETO` int(11) NOT NULL,
  `ID_OSEBA1` int(11) NOT NULL,
  `ID_OSEBA2` int(11) DEFAULT NULL,
  `ID_OSEBA3` int(11) DEFAULT NULL,
  `ID_PREDMET` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `izvedba_predmeta`
--

INSERT INTO `izvedba_predmeta` (`ID_IZVEDBA`, `ID_STUD_LETO`, `ID_OSEBA1`, `ID_OSEBA2`, `ID_OSEBA3`, `ID_PREDMET`) VALUES
  (1, 1, 2, NULL, NULL, 1),
  (2, 2, 2, NULL, NULL, 1),
  (3, 3, 2, NULL, NULL, 1),
  (4, 2, 2, NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `kandidat`
--

CREATE TABLE `kandidat` (
  `ID_KANDIDAT` int(11) NOT NULL,
  `EMSO` int(11) DEFAULT NULL,
  `IZKORISCEN` int(11) NOT NULL,
  `IME` char(50) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `PRIIMEK` char(50) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `VPISNA_STEVILKA` int(11) DEFAULT NULL,
  `ID_PROGRAM` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `kandidat`
--

INSERT INTO `kandidat` (`ID_KANDIDAT`, `EMSO`, `IZKORISCEN`, `IME`, `PRIIMEK`, `VPISNA_STEVILKA`, `ID_PROGRAM`) VALUES
  (1, 2147483647, 1, 'Janez', 'Novak', 63150000, 3),
  (2, 2147483647, 1, 'Janezek', 'Novakovic', 63150001, 3);

-- --------------------------------------------------------

--
-- Table structure for table `letnik`
--

CREATE TABLE `letnik` (
  `ID_LETNIK` int(11) NOT NULL,
  `LETNIK` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `letnik`
--

INSERT INTO `letnik` (`ID_LETNIK`, `LETNIK`) VALUES
  (1, 1),
  (2, 2),
  (3, 3),
  (4, 4),
  (5, 5),
  (6, 6);

-- --------------------------------------------------------

--
-- Table structure for table `nacin_studija`
--

CREATE TABLE `nacin_studija` (
  `ID_NACIN` int(11) NOT NULL,
  `OPIS_NACIN` char(50) COLLATE utf8_slovenian_ci NOT NULL,
  `ANG_OPIS_NACIN` char(50) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `AKTIVNOST` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `nacin_studija`
--

INSERT INTO `nacin_studija` (`ID_NACIN`, `OPIS_NACIN`, `ANG_OPIS_NACIN`, `AKTIVNOST`) VALUES
  (1, 'redni', 'full-time', 1),
  (2, 'izredni', 'part-time', 1);

-- --------------------------------------------------------

--
-- Table structure for table `naslov`
--

CREATE TABLE `naslov` (
  `ID_NASLOV` int(11) NOT NULL,
  `ID_POSTA` int(11) NOT NULL,
  `ID_OBCINA` int(11) NOT NULL,
  `ID_DRZAVA` int(11) NOT NULL,
  `ID_OSEBA` int(11) DEFAULT NULL,
  `JE_ZAVROCANJE` int(11) DEFAULT NULL,
  `JE_STALNI` int(11) DEFAULT NULL,
  `ULICA` char(50) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `HISNA_STEVILKA` char(50) COLLATE utf8_slovenian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `naslov`
--

INSERT INTO `naslov` (`ID_NASLOV`, `ID_POSTA`, `ID_OBCINA`, `ID_DRZAVA`, `ID_OSEBA`, `JE_ZAVROCANJE`, `JE_STALNI`, `ULICA`, `HISNA_STEVILKA`) VALUES
  (1, 1, 1, 4, 1, 1, 0, 'naslovzavrocanje', '13'),
  (2, 1, 1, 8, 1, 0, 1, 'stalninaslov', '12');

-- --------------------------------------------------------

--
-- Table structure for table `obcina`
--

CREATE TABLE `obcina` (
  `ID_OBCINA` int(11) NOT NULL,
  `IME_OBCINA` char(50) COLLATE utf8_slovenian_ci NOT NULL,
  `AKTIVNOST` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `obcina`
--

INSERT INTO `obcina` (`ID_OBCINA`, `IME_OBCINA`, `AKTIVNOST`) VALUES
  (1, 'Ajdovščina', 1),
  (2, 'Beltinci', 1),
  (3, 'Bled', 1),
  (4, 'Bohinj', 1),
  (5, 'Borovnica', 1),
  (6, 'Bovec', 1),
  (7, 'Brda', 1),
  (8, 'Brezovica', 1),
  (9, 'Brežice', 1),
  (10, 'Tišina', 1),
  (11, 'Celje', 1),
  (12, 'Cerklje na Gorenjskem', 1),
  (13, 'Cerknica', 1),
  (14, 'Cerkno', 1),
  (15, 'Črenšovci', 1),
  (16, 'Črna na Koroškem', 1),
  (17, 'Črnomelj', 1),
  (18, 'Destrnik', 1),
  (19, 'Divača', 1),
  (20, 'Dobrepolje', 1),
  (21, 'Dobrova - Polhov Gradec', 1),
  (22, 'Dol pri Ljubljani', 1),
  (23, 'Domžale', 1),
  (24, 'Dornava', 1),
  (25, 'Dravograd', 1),
  (26, 'Duplek', 1),
  (27, 'Gorenja vas - Poljane', 1),
  (28, 'Gorišnica', 1),
  (29, 'Gornja Radgona', 1),
  (30, 'Gornji Grad', 1),
  (31, 'Gornji Petrovci', 1),
  (32, 'Grosuplje', 1),
  (33, 'Šalovci', 1),
  (34, 'Hrastnik', 1),
  (35, 'Hrpelje - Kozina', 1),
  (36, 'Idrija', 1),
  (37, 'Ig', 1),
  (38, 'Ilirska Bistrica', 1),
  (39, 'Ivančna Gorica', 1),
  (40, 'Izola', 1),
  (41, 'Jesenice', 1),
  (42, 'Juršinci', 1),
  (43, 'Kamnik', 1),
  (44, 'Kanal', 1),
  (45, 'Kidričevo', 1),
  (46, 'Kobarid', 1),
  (47, 'Kobilje', 1),
  (48, 'Kočevje', 1),
  (49, 'Komen', 1),
  (50, 'Koper', 1),
  (51, 'Kozje', 1),
  (52, 'Kranj', 1),
  (53, 'Kranjska Gora', 1),
  (54, 'Krško', 1),
  (55, 'Kungota', 1),
  (56, 'Kuzma', 1),
  (57, 'Laško', 1),
  (58, 'Lenart', 1),
  (59, 'Lendava', 1),
  (60, 'Litija', 1),
  (61, 'Ljubljana', 1),
  (62, 'Ljubno', 1),
  (63, 'Ljutomer', 1),
  (64, 'Logatec', 1),
  (65, 'Loška dolina', 1),
  (66, 'Loški Potok', 1),
  (67, 'Luče', 1),
  (68, 'Lukovica', 1),
  (69, 'Majšperk', 1),
  (70, 'Maribor', 1),
  (71, 'Medvode', 1),
  (72, 'Mengeš', 1),
  (73, 'Metlika', 1),
  (74, 'Mežica', 1),
  (75, 'Miren - Kostanjevica', 1),
  (76, 'Mislinja', 1),
  (77, 'Moravče', 1),
  (78, 'Moravske Toplice', 1),
  (79, 'Mozirje', 1),
  (80, 'Murska Sobota', 1),
  (81, 'Muta', 1),
  (82, 'Naklo', 1),
  (83, 'Nazarje', 1),
  (84, 'Nova Gorica', 1),
  (85, 'Novo mesto', 1),
  (86, 'Odranci', 1),
  (87, 'Ormož', 1),
  (88, 'Osilnica', 1),
  (89, 'Pesnica', 1),
  (90, 'Piran', 1),
  (91, 'Pivka', 1),
  (92, 'Podčetrtek', 1),
  (93, 'Podvelka', 1),
  (94, 'Postojna', 1),
  (95, 'Preddvor', 1),
  (96, 'Ptuj', 1),
  (97, 'Puconci', 1),
  (98, 'Rače - Fram', 1),
  (99, 'Radeče', 1),
  (100, 'Radenci', 1),
  (101, 'Radlje ob Dravi', 1),
  (102, 'Radovljica', 1),
  (103, 'Ravne na Koroškem', 1),
  (104, 'Ribnica', 1),
  (105, 'Rogašovci', 1),
  (106, 'Rogaška Slatina', 1),
  (107, 'Rogatec', 1),
  (108, 'Ruše', 1),
  (109, 'Semič', 1),
  (110, 'Sevnica', 1),
  (111, 'Sežana', 1),
  (112, 'Slovenj Gradec', 1),
  (113, 'Slovenska Bistrica', 1),
  (114, 'Slovenske Konjice', 1),
  (115, 'Starše', 1),
  (116, 'Sveti Jurij ob Ščavnici', 1),
  (117, 'Šenčur', 1),
  (118, 'Šentilj', 1),
  (119, 'Šentjernej', 1),
  (120, 'Šentjur pri Celju', 1),
  (121, 'Škocjan', 1),
  (122, 'Škofja Loka', 1),
  (123, 'Škofljica', 1),
  (124, 'Šmarje pri Jelšah', 1),
  (125, 'Šmartno ob Paki', 1),
  (126, 'Šoštanj', 1),
  (127, 'Štore', 1),
  (128, 'Tolmin', 1),
  (129, 'Trbovlje', 1),
  (130, 'Trebnje', 1),
  (131, 'Tržič', 1),
  (132, 'Turnišče', 1),
  (133, 'Velenje', 1),
  (134, 'Velike Lašče', 1),
  (135, 'Videm', 1),
  (136, 'Vipava', 1),
  (137, 'Vitanje', 1),
  (138, 'Vodice', 1),
  (139, 'Vojnik', 1),
  (140, 'Vrhnika', 1),
  (141, 'Vuzenica', 1),
  (142, 'Zagorje ob Savi', 1),
  (143, 'Zavrč', 1),
  (144, 'Zreče', 1),
  (146, 'Železniki', 1),
  (147, 'Žiri', 1),
  (148, 'Benedikt', 1),
  (149, 'Bistrica ob Sotli', 1),
  (150, 'Bloke', 1),
  (151, 'Braslovče', 1),
  (152, 'Cankova', 1),
  (153, 'Cerkvenjak', 1),
  (154, 'Dobje', 1),
  (155, 'Dobrna', 1),
  (156, 'Dobrovnik', 1),
  (157, 'Dolenjske Toplice', 1),
  (158, 'Grad', 1),
  (159, 'Hajdina', 1),
  (160, 'Hoče - Slivnica', 1),
  (161, 'Hodoš', 1),
  (162, 'Horjul', 1),
  (163, 'Jezersko', 1),
  (164, 'Komenda', 1),
  (165, 'Kostel', 1),
  (166, 'Križevci', 1),
  (167, 'Lovrenc na Pohorju', 1),
  (168, 'Markovci', 1),
  (169, 'Miklavž na Dravskem polju', 1),
  (170, 'Mirna Peč', 1),
  (171, 'Oplotnica', 1),
  (172, 'Podlehnik', 1),
  (173, 'Polzela', 1),
  (174, 'Prebold', 1),
  (175, 'Prevalje', 1),
  (176, 'Razkrižje', 1),
  (177, 'Ribnica na Pohorju', 1),
  (178, 'Selnica ob Dravi', 1),
  (179, 'Sodražica', 1),
  (180, 'Solčava', 1),
  (181, 'Sveta Ana', 1),
  (182, 'Sveti Andraž v Slov. Goricah', 1),
  (183, 'Šempeter - Vrtojba', 1),
  (184, 'Tabor', 1),
  (185, 'Trnovska vas', 1),
  (186, 'Trzin', 1),
  (187, 'Velika Polana', 1),
  (188, 'Veržej', 1),
  (189, 'Vransko', 1),
  (190, 'Žalec', 1),
  (191, 'Žetale', 1),
  (192, 'Žirovnica', 1),
  (193, 'Žužemberk', 1),
  (194, 'Šmartno pri Litiji', 1),
  (195, 'Apače', 1),
  (196, 'Cirkulane', 1),
  (197, 'Kostanjevica na Krki', 1),
  (198, 'Makole', 1),
  (199, 'Mokronog - Trebelno', 1),
  (200, 'Poljčane', 1),
  (201, 'Renče - Vogrsko', 1),
  (202, 'Središče ob Dravi', 1),
  (203, 'Straža', 1),
  (204, 'Sv. Trojica v Slov. Goricah', 1),
  (205, 'Sveti Tomaž', 1),
  (206, 'Šmarješke Toplice', 1),
  (207, 'Gorje', 1),
  (208, 'Log - Dragomer', 1),
  (209, 'Rečica ob Savinji', 1),
  (210, 'Sveti Jurij v Slov. Goricah', 1),
  (211, 'Šentrupert', 1),
  (212, 'Mirna', 1),
  (213, 'Ankaran', 1);

-- --------------------------------------------------------

--
-- Table structure for table `oblika_studija`
--

CREATE TABLE `oblika_studija` (
  `ID_OBLIKA` int(11) NOT NULL,
  `NAZIV_OBLIKA` char(50) COLLATE utf8_slovenian_ci NOT NULL,
  `ANG_OPIS_OBLIKA` char(50) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `AKTIVNOST` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `oblika_studija`
--

INSERT INTO `oblika_studija` (`ID_OBLIKA`, `NAZIV_OBLIKA`, `ANG_OPIS_OBLIKA`, `AKTIVNOST`) VALUES
  (1, 'na lokaciji', 'on site', 0),
  (2, 'na daljavo', 'distance learning', 0),
  (3, 'e-studij', 'e-studij', 0);

-- --------------------------------------------------------

--
-- Table structure for table `oseba`
--

CREATE TABLE `oseba` (
  `ID_OSEBA` int(11) NOT NULL,
  `IME` char(50) COLLATE utf8_slovenian_ci NOT NULL,
  `PRIIMEK` char(50) COLLATE utf8_slovenian_ci NOT NULL,
  `EMAIL` char(30) COLLATE utf8_slovenian_ci NOT NULL,
  `UPORABNISKO_IME` char(10) COLLATE utf8_slovenian_ci NOT NULL,
  `GESLO` char(60) COLLATE utf8_slovenian_ci NOT NULL,
  `VRSTA_VLOGE` char(1) COLLATE utf8_slovenian_ci NOT NULL,
  `TELEFONSKA_STEVILKA` char(20) COLLATE utf8_slovenian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `oseba`
--

INSERT INTO `oseba` (`ID_OSEBA`, `IME`, `PRIIMEK`, `EMAIL`, `UPORABNISKO_IME`, `GESLO`, `VRSTA_VLOGE`, `TELEFONSKA_STEVILKA`) VALUES
  (1, 'Janez', 'Novak', 'testS', 'testS', '123456', 's', '040040040'),
  (2, 'An', 'Ban', 'testP', 'testP', '123456', 'p', '030030030'),
  (3, 'Ancka', 'Novak', 'testR', 'testR', '123456', 'r', '050505050'),
  (4, 'Janezek', 'Novakovic', 'testS2', 'testS2', '123456', 's', '123581321'),
  (5, 'Admin', 'Admin', 'testA', 'testA', '123456', 'a', '123581321');

-- --------------------------------------------------------

--
-- Table structure for table `posta`
--

CREATE TABLE `posta` (
  `ID_POSTA` int(11) NOT NULL,
  `ST_POSTA` char(4) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `KRAJ` char(30) COLLATE utf8_slovenian_ci NOT NULL,
  `AKTIVNOST` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `posta`
--

INSERT INTO `posta` (`ID_POSTA`, `ST_POSTA`, `KRAJ`, `AKTIVNOST`) VALUES
  (1, '1000', 'Ljubljana', 1),
  (2, '2000', 'Maribor', 1);

-- --------------------------------------------------------

--
-- Table structure for table `predmet`
--

CREATE TABLE `predmet` (
  `ID_PREDMET` int(11) NOT NULL,
  `IME_PREDMET` char(50) COLLATE utf8_slovenian_ci NOT NULL,
  `AKTIVNOST` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `predmet`
--

INSERT INTO `predmet` (`ID_PREDMET`, `IME_PREDMET`, `AKTIVNOST`) VALUES
  (1, 'TPO', 1),
  (2, 'PRPO', 1),
  (3, 'SP', 1),
  (4, 'EP', 1),
  (5, 'OM', 1),
  (6, 'P1', 1),
  (7, 'PPJ', 1),
  (8, 'Sport', 1);

-- --------------------------------------------------------

--
-- Table structure for table `predmeti_studenta`
--

CREATE TABLE `predmeti_studenta` (
  `ID_PREDMETISTUDENTA` int(11) NOT NULL,
  `ID_VPIS` int(11) NOT NULL,
  `ID_PREDMET` int(11) NOT NULL,
  `ID_STUD_LETO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `predmetnik`
--

CREATE TABLE `predmetnik` (
  `ID_PREDMETNIK` int(11) NOT NULL,
  `ID_PREDMET` int(11) NOT NULL,
  `ID_DELPREDMETNIKA` int(11) NOT NULL,
  `ID_LETNIK` int(11) NOT NULL,
  `ID_STUD_LETO` int(11) NOT NULL,
  `ID_PROGRAM` int(11) NOT NULL,
  `AKTIVNOST` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `predmetnik`
--

INSERT INTO `predmetnik` (`ID_PREDMETNIK`, `ID_PREDMET`, `ID_DELPREDMETNIKA`, `ID_LETNIK`, `ID_STUD_LETO`, `ID_PROGRAM`, `AKTIVNOST`) VALUES
  (1, 1, 1, 3, 2, 3, 1),
  (2, 2, 1, 3, 2, 3, 1),
  (3, 3, 1, 3, 2, 3, 1),
  (4, 4, 3, 3, 2, 3, 1),
  (5, 5, 2, 3, 2, 3, 1),
  (6, 6, 3, 1, 2, 3, 1),
  (7, 7, 4, 3, 2, 3, 1),
  (8, 8, 5, 3, 2, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `prijava`
--

CREATE TABLE `prijava` (
  `ID_PRIJAVA` int(11) NOT NULL,
  `ID_IZPIT` int(11) DEFAULT NULL,
  `ID_PREDMETISTUDENTA` int(11) NOT NULL,
  `ID_ROK` int(11) NOT NULL,
  `ZAP_ST_POLAGANJ` int(11) NOT NULL,
  `PODATKI_O_PLACILU` char(50) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `VPISNA_STEVILKA` int(11) DEFAULT NULL,
  `IME_PREDMET` char(50) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `STUD_LETO` int(11) DEFAULT NULL,
  `DATUM_ROKA` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `program`
--

CREATE TABLE `program` (
  `ID_PROGRAM` int(11) NOT NULL,
  `ID_STOPNJA` int(11) NOT NULL,
  `SIFRA_PROGRAM` char(15) COLLATE utf8_slovenian_ci NOT NULL,
  `NAZIV_PROGRAM` char(100) COLLATE utf8_slovenian_ci NOT NULL,
  `ST_SEMESTROV` int(11) NOT NULL,
  `SIFRA_EVS` int(11) DEFAULT NULL,
  `AKTIVNOST` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `program`
--

INSERT INTO `program` (`ID_PROGRAM`, `ID_STOPNJA`, `SIFRA_PROGRAM`, `NAZIV_PROGRAM`, `ST_SEMESTROV`, `SIFRA_EVS`, `AKTIVNOST`) VALUES
  (1, 8, 'LE', 'INF. SISTEMI IN ODLOČANJE - DR', 4, 1000479, 1),
  (2, 7, 'L3', 'INFORMAC. SISTEMI IN ODLOČANJE - MAG', 4, 1000480, 1),
  (3, 4, 'X5', 'Kognitivna znanost MAG II. st.', 4, 1000472, 1),
  (4, 3, 'MM', 'Multimedija UN 1. st.', 6, 1001001, 1),
  (5, 4, '7002801', 'PEDAGOŠKO RAČ. IN INF. MAG-II. st.', 4, 1000977, 1),
  (6, 1, 'L2', 'RAČUNAL. IN INFROMATIKA UN', 9, 1000475, 1),
  (7, 1, 'P7', 'RAČUNAL. IN MATEMATIKA UN', 8, 1000425, 1),
  (8, 2, 'HB', 'RAČUNAL. IN INFORMATIKA VS', 6, 1000477, 1),
  (9, 3, 'VV', 'RAČUNAL. IN MATEMA. UN-I.ST', 6, 1000407, 1),
  (10, 4, 'L1', 'RAČUNALN. IN INFORM. MAG II.ST', 4, 1000471, 1),
  (11, 3, 'VT', 'RAČUNALN. IN INFORM. UN-I.ST', 6, 1000468, 1),
  (12, 3, 'VU', 'RAČUNALN. IN INFORM. VS-I.ST', 6, 1000470, 1),
  (13, 5, 'X6', 'RAČUNALNIŠ. IN INF. DR-III ST.', 6, 1000474, 1),
  (14, 8, '7E', 'RAČUNALNIŠTVO IN INF. - DR', 4, 1000478, 1),
  (15, 7, '71', 'RAČUNALNIŠTVO IN INF. - MAG', 4, 1000481, 1),
  (16, 3, '02', 'RAČUNALNIŠTVO IN INF. - VIS', 8, 1, 1),
  (17, 3, '03', 'RAČUNALNIŠTVO IN INF. - VŠ', 4, 1, 1),
  (18, 4, 'KP00', 'Račnalništvo in matematika MAG II. st.', 4, 1000934, 1),
  (19, 3, 'Z2', 'Upravna informatika UN 1. st.', 6, 1000469, 1),
  (20, 5, 'XU', 'Humanistika in družb.-DR. III', 6, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rok`
--

CREATE TABLE `rok` (
  `ID_ROK` int(11) NOT NULL,
  `ID_IZVEDBA` int(11) NOT NULL,
  `DATUM_ROKA` date NOT NULL,
  `CAS_ROKA` time NOT NULL,
  `AKTIVNOST` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stopnja`
--

CREATE TABLE `stopnja` (
  `ID_STOPNJA` int(11) NOT NULL,
  `NAZIV` char(50) COLLATE utf8_slovenian_ci NOT NULL,
  `MOZEN_VPIS` int(11) NOT NULL,
  `SIFRA` char(10) COLLATE utf8_slovenian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `stopnja`
--

INSERT INTO `stopnja` (`ID_STOPNJA`, `NAZIV`, `MOZEN_VPIS`, `SIFRA`) VALUES
  (1, 'Stari dodiplomski program-uni', 0, '123'),
  (2, 'Stari dodiplomski-visokosolski', 0, '123'),
  (3, '1. stopnja', 1, '123'),
  (4, '2. stopnja', 1, '123'),
  (5, '3. stopnja', 1, '123'),
  (6, 'EM', 1, '123'),
  (7, 'Stari magistrski studij', 0, '123'),
  (8, 'Stari doktorski studij', 0, '123');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `VPISNA_STEVILKA` int(11) NOT NULL,
  `ID_OSEBA` int(11) NOT NULL,
  `ID_KANDIDAT` int(11) DEFAULT NULL,
  `ID_VPIS` int(11) DEFAULT NULL,
  `EMSO` char(20) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `ID_PROGRAM` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`VPISNA_STEVILKA`, `ID_OSEBA`, `ID_KANDIDAT`, `ID_VPIS`, `EMSO`, `ID_PROGRAM`) VALUES
  (63150000, 1, 1, 1, '2505996500532', 3),
  (63150001, 4, 2, 2, '1234567891234', 3);

-- --------------------------------------------------------

--
-- Table structure for table `studijsko_leto`
--

CREATE TABLE `studijsko_leto` (
  `ID_STUD_LETO` int(11) NOT NULL,
  `STUD_LETO` char(10) COLLATE utf8_slovenian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `studijsko_leto`
--

INSERT INTO `studijsko_leto` (`ID_STUD_LETO`, `STUD_LETO`) VALUES
  (1, '2016/17'),
  (2, '2017/18'),
  (3, '2018/19');

-- --------------------------------------------------------

--
-- Table structure for table `vpis`
--

CREATE TABLE `vpis` (
  `ID_VPIS` int(11) NOT NULL,
  `ID_PROGRAM` int(11) NOT NULL,
  `ID_NACIN` int(11) NOT NULL,
  `ID_STUD_LETO` int(11) NOT NULL,
  `ID_VRSTAVPISA` int(11) NOT NULL,
  `ID_OBLIKA` int(11) NOT NULL,
  `ID_LETNIK` int(11) NOT NULL,
  `POTRJENOST_VPISA` int(11) NOT NULL,
  `VPISNA_STEVILKA` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `vpis`
--

INSERT INTO `vpis` (`ID_VPIS`, `ID_PROGRAM`, `ID_NACIN`, `ID_STUD_LETO`, `ID_VRSTAVPISA`, `ID_OBLIKA`, `ID_LETNIK`, `POTRJENOST_VPISA`, `VPISNA_STEVILKA`) VALUES
  (1, 3, 1, 2, 1, 1, 1, 1, 63150000),
  (2, 3, 1, 2, 1, 1, 1, 1, 63150001);

-- --------------------------------------------------------

--
-- Table structure for table `vrsta_vpisa`
--

CREATE TABLE `vrsta_vpisa` (
  `ID_VRSTAVPISA` int(11) NOT NULL,
  `OPIS_VPISA` char(30) COLLATE utf8_slovenian_ci NOT NULL,
  `AKTIVNOST` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `vrsta_vpisa`
--

INSERT INTO `vrsta_vpisa` (`ID_VRSTAVPISA`, `OPIS_VPISA`, `AKTIVNOST`) VALUES
  (1, 'Prvi vpis v letnik', 1),
  (2, 'Ponavlanje letnika', 1),
  (3, 'Prvi vpis v letnik/dodatno let', 1);

-- --------------------------------------------------------

--
-- Table structure for table `zeton`
--

CREATE TABLE `zeton` (
  `ID_ZETON` int(11) NOT NULL,
  `ID_OSEBA` int(11) NOT NULL,
  `ID_LETNIK` int(11) NOT NULL,
  `ID_STUD_LETO` int(11) NOT NULL,
  `EMSO` int(11) NOT NULL,
  `IZKORISCEN` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `del_predmetnika`
--
ALTER TABLE `del_predmetnika`
  ADD PRIMARY KEY (`ID_DELPREDMETNIKA`);

--
-- Indexes for table `drzava`
--
ALTER TABLE `drzava`
  ADD PRIMARY KEY (`ID_DRZAVA`);

--
-- Indexes for table `izpit`
--
ALTER TABLE `izpit`
  ADD PRIMARY KEY (`ID_IZPIT`),
  ADD KEY `FK_RELATIONSHIP_28` (`ID_PRIJAVA`);

--
-- Indexes for table `izvedba_predmeta`
--
ALTER TABLE `izvedba_predmeta`
  ADD PRIMARY KEY (`ID_IZVEDBA`),
  ADD KEY `FK_RELATIONSHIP_18` (`ID_PREDMET`),
  ADD KEY `FK_RELATIONSHIP_19` (`ID_STUD_LETO`),
  ADD KEY `2131_idx` (`ID_OSEBA1`),
  ADD KEY `Je_UCITELJ2_idx` (`ID_OSEBA2`),
  ADD KEY `Je_UCITELJ3_idx` (`ID_OSEBA3`);

--
-- Indexes for table `kandidat`
--
ALTER TABLE `kandidat`
  ADD PRIMARY KEY (`ID_KANDIDAT`),
  ADD KEY `FK_PROGRAM_idx` (`ID_PROGRAM`);

--
-- Indexes for table `letnik`
--
ALTER TABLE `letnik`
  ADD PRIMARY KEY (`ID_LETNIK`);

--
-- Indexes for table `nacin_studija`
--
ALTER TABLE `nacin_studija`
  ADD PRIMARY KEY (`ID_NACIN`);

--
-- Indexes for table `naslov`
--
ALTER TABLE `naslov`
  ADD PRIMARY KEY (`ID_NASLOV`),
  ADD KEY `FK_RELATIONSHIP_30` (`ID_POSTA`),
  ADD KEY `FK_RELATIONSHIP_31` (`ID_OBCINA`),
  ADD KEY `FK_RELATIONSHIP_32` (`ID_OSEBA`),
  ADD KEY `FK_RELATIONSHIP_33` (`ID_DRZAVA`);

--
-- Indexes for table `obcina`
--
ALTER TABLE `obcina`
  ADD PRIMARY KEY (`ID_OBCINA`);

--
-- Indexes for table `oblika_studija`
--
ALTER TABLE `oblika_studija`
  ADD PRIMARY KEY (`ID_OBLIKA`);

--
-- Indexes for table `oseba`
--
ALTER TABLE `oseba`
  ADD PRIMARY KEY (`ID_OSEBA`);

--
-- Indexes for table `posta`
--
ALTER TABLE `posta`
  ADD PRIMARY KEY (`ID_POSTA`);

--
-- Indexes for table `predmet`
--
ALTER TABLE `predmet`
  ADD PRIMARY KEY (`ID_PREDMET`);

--
-- Indexes for table `predmeti_studenta`
--
ALTER TABLE `predmeti_studenta`
  ADD PRIMARY KEY (`ID_PREDMETISTUDENTA`),
  ADD KEY `FK_RELATIONSHIP_23` (`ID_VPIS`),
  ADD KEY `FK_RELATIONSHIP_24` (`ID_PREDMET`),
  ADD KEY `FK_STUD_LETO_idx` (`ID_STUD_LETO`);

--
-- Indexes for table `predmetnik`
--
ALTER TABLE `predmetnik`
  ADD PRIMARY KEY (`ID_PREDMETNIK`),
  ADD KEY `FK_RELATIONSHIP_13` (`ID_PROGRAM`),
  ADD KEY `FK_RELATIONSHIP_14` (`ID_LETNIK`),
  ADD KEY `FK_RELATIONSHIP_17` (`ID_STUD_LETO`),
  ADD KEY `FK_PREDMET_idx` (`ID_PREDMET`),
  ADD KEY `FK_DELPREDMETNIKA_idx` (`ID_DELPREDMETNIKA`);

--
-- Indexes for table `prijava`
--
ALTER TABLE `prijava`
  ADD PRIMARY KEY (`ID_PRIJAVA`),
  ADD KEY `FK_RELATIONSHIP_26` (`ID_ROK`),
  ADD KEY `FK_RELATIONSHIP_27` (`ID_PREDMETISTUDENTA`),
  ADD KEY `FK_RELATIONSHIP_29` (`ID_IZPIT`);

--
-- Indexes for table `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`ID_PROGRAM`),
  ADD KEY `FK_STOPNJA_idx` (`ID_STOPNJA`);

--
-- Indexes for table `rok`
--
ALTER TABLE `rok`
  ADD PRIMARY KEY (`ID_ROK`),
  ADD KEY `FK_RELATIONSHIP_25` (`ID_IZVEDBA`);

--
-- Indexes for table `stopnja`
--
ALTER TABLE `stopnja`
  ADD PRIMARY KEY (`ID_STOPNJA`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`VPISNA_STEVILKA`),
  ADD KEY `FK_INHERITANCE_3` (`ID_OSEBA`),
  ADD KEY `FK_RELATIONSHIP_5` (`ID_KANDIDAT`),
  ADD KEY `FK_RELATIONSHIP_6` (`ID_VPIS`),
  ADD KEY `FK_PROGRAM_idx` (`ID_PROGRAM`);

--
-- Indexes for table `studijsko_leto`
--
ALTER TABLE `studijsko_leto`
  ADD PRIMARY KEY (`ID_STUD_LETO`);

--
-- Indexes for table `vpis`
--
ALTER TABLE `vpis`
  ADD PRIMARY KEY (`ID_VPIS`),
  ADD KEY `FK_RELATIONSHIP_10` (`ID_OBLIKA`),
  ADD KEY `FK_RELATIONSHIP_11` (`ID_LETNIK`),
  ADD KEY `FK_RELATIONSHIP_12` (`ID_PROGRAM`),
  ADD KEY `FK_RELATIONSHIP_16` (`ID_STUD_LETO`),
  ADD KEY `FK_RELATIONSHIP_8` (`ID_VRSTAVPISA`),
  ADD KEY `FK_RELATIONSHIP_9` (`ID_NACIN`);

--
-- Indexes for table `vrsta_vpisa`
--
ALTER TABLE `vrsta_vpisa`
  ADD PRIMARY KEY (`ID_VRSTAVPISA`);

--
-- Indexes for table `zeton`
--
ALTER TABLE `zeton`
  ADD PRIMARY KEY (`ID_ZETON`),
  ADD KEY `FK_RELATIONSHIP_7` (`ID_OSEBA`),
  ADD KEY `FK_STUD_LETO_idx` (`ID_STUD_LETO`),
  ADD KEY `FK_LETNIK_idx` (`ID_LETNIK`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `del_predmetnika`
--
ALTER TABLE `del_predmetnika`
  MODIFY `ID_DELPREDMETNIKA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `drzava`
--
ALTER TABLE `drzava`
  MODIFY `ID_DRZAVA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=895;

--
-- AUTO_INCREMENT for table `izpit`
--
ALTER TABLE `izpit`
  MODIFY `ID_IZPIT` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `izvedba_predmeta`
--
ALTER TABLE `izvedba_predmeta`
  MODIFY `ID_IZVEDBA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kandidat`
--
ALTER TABLE `kandidat`
  MODIFY `ID_KANDIDAT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `letnik`
--
ALTER TABLE `letnik`
  MODIFY `ID_LETNIK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `nacin_studija`
--
ALTER TABLE `nacin_studija`
  MODIFY `ID_NACIN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `naslov`
--
ALTER TABLE `naslov`
  MODIFY `ID_NASLOV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `obcina`
--
ALTER TABLE `obcina`
  MODIFY `ID_OBCINA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- AUTO_INCREMENT for table `oblika_studija`
--
ALTER TABLE `oblika_studija`
  MODIFY `ID_OBLIKA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `oseba`
--
ALTER TABLE `oseba`
  MODIFY `ID_OSEBA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `posta`
--
ALTER TABLE `posta`
  MODIFY `ID_POSTA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `predmet`
--
ALTER TABLE `predmet`
  MODIFY `ID_PREDMET` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `predmeti_studenta`
--
ALTER TABLE `predmeti_studenta`
  MODIFY `ID_PREDMETISTUDENTA` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `predmetnik`
--
ALTER TABLE `predmetnik`
  MODIFY `ID_PREDMETNIK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `prijava`
--
ALTER TABLE `prijava`
  MODIFY `ID_PRIJAVA` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `program`
--
ALTER TABLE `program`
  MODIFY `ID_PROGRAM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `rok`
--
ALTER TABLE `rok`
  MODIFY `ID_ROK` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stopnja`
--
ALTER TABLE `stopnja`
  MODIFY `ID_STOPNJA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `studijsko_leto`
--
ALTER TABLE `studijsko_leto`
  MODIFY `ID_STUD_LETO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vpis`
--
ALTER TABLE `vpis`
  MODIFY `ID_VPIS` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vrsta_vpisa`
--
ALTER TABLE `vrsta_vpisa`
  MODIFY `ID_VRSTAVPISA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `zeton`
--
ALTER TABLE `zeton`
  MODIFY `ID_ZETON` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `izpit`
--
ALTER TABLE `izpit`
  ADD CONSTRAINT `FK_RELATIONSHIP_28` FOREIGN KEY (`ID_PRIJAVA`) REFERENCES `prijava` (`ID_PRIJAVA`);

--
-- Constraints for table `izvedba_predmeta`
--
ALTER TABLE `izvedba_predmeta`
  ADD CONSTRAINT `FK_RELATIONSHIP_18` FOREIGN KEY (`ID_PREDMET`) REFERENCES `predmet` (`ID_PREDMET`),
  ADD CONSTRAINT `FK_RELATIONSHIP_19` FOREIGN KEY (`ID_STUD_LETO`) REFERENCES `studijsko_leto` (`ID_STUD_LETO`),
  ADD CONSTRAINT `Je_UCITELJ1` FOREIGN KEY (`ID_OSEBA1`) REFERENCES `oseba` (`ID_OSEBA`),
  ADD CONSTRAINT `Je_UCITELJ2` FOREIGN KEY (`ID_OSEBA2`) REFERENCES `oseba` (`ID_OSEBA`),
  ADD CONSTRAINT `Je_UCITELJ3` FOREIGN KEY (`ID_OSEBA3`) REFERENCES `oseba` (`ID_OSEBA`);

--
-- Constraints for table `kandidat`
--
ALTER TABLE `kandidat`
  ADD CONSTRAINT `FK_PROGRAM_2` FOREIGN KEY (`ID_PROGRAM`) REFERENCES `program` (`ID_PROGRAM`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `naslov`
--
ALTER TABLE `naslov`
  ADD CONSTRAINT `FK_RELATIONSHIP_30` FOREIGN KEY (`ID_POSTA`) REFERENCES `posta` (`ID_POSTA`),
  ADD CONSTRAINT `FK_RELATIONSHIP_31` FOREIGN KEY (`ID_OBCINA`) REFERENCES `obcina` (`ID_OBCINA`),
  ADD CONSTRAINT `FK_RELATIONSHIP_32` FOREIGN KEY (`ID_OSEBA`) REFERENCES `student` (`ID_OSEBA`),
  ADD CONSTRAINT `FK_RELATIONSHIP_33` FOREIGN KEY (`ID_DRZAVA`) REFERENCES `drzava` (`ID_DRZAVA`);

--
-- Constraints for table `predmeti_studenta`
--
ALTER TABLE `predmeti_studenta`
  ADD CONSTRAINT `FK_RELATIONSHIP_23` FOREIGN KEY (`ID_VPIS`) REFERENCES `vpis` (`ID_VPIS`),
  ADD CONSTRAINT `FK_RELATIONSHIP_24` FOREIGN KEY (`ID_PREDMET`) REFERENCES `predmet` (`ID_PREDMET`),
  ADD CONSTRAINT `FK_STUD_LETO_2` FOREIGN KEY (`ID_STUD_LETO`) REFERENCES `studijsko_leto` (`ID_STUD_LETO`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `predmetnik`
--
ALTER TABLE `predmetnik`
  ADD CONSTRAINT `FK_DELPREDMETNIKA` FOREIGN KEY (`ID_DELPREDMETNIKA`) REFERENCES `del_predmetnika` (`ID_DELPREDMETNIKA`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_PREDMET` FOREIGN KEY (`ID_PREDMET`) REFERENCES `predmet` (`ID_PREDMET`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_RELATIONSHIP_13` FOREIGN KEY (`ID_PROGRAM`) REFERENCES `program` (`ID_PROGRAM`),
  ADD CONSTRAINT `FK_RELATIONSHIP_14` FOREIGN KEY (`ID_LETNIK`) REFERENCES `letnik` (`ID_LETNIK`),
  ADD CONSTRAINT `FK_RELATIONSHIP_17` FOREIGN KEY (`ID_STUD_LETO`) REFERENCES `studijsko_leto` (`ID_STUD_LETO`);

--
-- Constraints for table `prijava`
--
ALTER TABLE `prijava`
  ADD CONSTRAINT `FK_RELATIONSHIP_26` FOREIGN KEY (`ID_ROK`) REFERENCES `rok` (`ID_ROK`),
  ADD CONSTRAINT `FK_RELATIONSHIP_27` FOREIGN KEY (`ID_PREDMETISTUDENTA`) REFERENCES `predmeti_studenta` (`ID_PREDMETISTUDENTA`),
  ADD CONSTRAINT `FK_RELATIONSHIP_29` FOREIGN KEY (`ID_IZPIT`) REFERENCES `izpit` (`ID_IZPIT`);

--
-- Constraints for table `program`
--
ALTER TABLE `program`
  ADD CONSTRAINT `FK_STOPNJA` FOREIGN KEY (`ID_STOPNJA`) REFERENCES `stopnja` (`ID_STOPNJA`);

--
-- Constraints for table `rok`
--
ALTER TABLE `rok`
  ADD CONSTRAINT `FK_RELATIONSHIP_25` FOREIGN KEY (`ID_IZVEDBA`) REFERENCES `izvedba_predmeta` (`ID_IZVEDBA`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `FK_INHERITANCE_3` FOREIGN KEY (`ID_OSEBA`) REFERENCES `oseba` (`ID_OSEBA`),
  ADD CONSTRAINT `FK_PROGRAM_1` FOREIGN KEY (`ID_PROGRAM`) REFERENCES `program` (`ID_PROGRAM`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_RELATIONSHIP_5` FOREIGN KEY (`ID_KANDIDAT`) REFERENCES `kandidat` (`ID_KANDIDAT`),
  ADD CONSTRAINT `FK_RELATIONSHIP_6` FOREIGN KEY (`ID_VPIS`) REFERENCES `vpis` (`ID_VPIS`);

--
-- Constraints for table `vpis`
--
ALTER TABLE `vpis`
  ADD CONSTRAINT `FK_RELATIONSHIP_10` FOREIGN KEY (`ID_OBLIKA`) REFERENCES `oblika_studija` (`ID_OBLIKA`),
  ADD CONSTRAINT `FK_RELATIONSHIP_11` FOREIGN KEY (`ID_LETNIK`) REFERENCES `letnik` (`ID_LETNIK`),
  ADD CONSTRAINT `FK_RELATIONSHIP_12` FOREIGN KEY (`ID_PROGRAM`) REFERENCES `program` (`ID_PROGRAM`),
  ADD CONSTRAINT `FK_RELATIONSHIP_16` FOREIGN KEY (`ID_STUD_LETO`) REFERENCES `studijsko_leto` (`ID_STUD_LETO`),
  ADD CONSTRAINT `FK_RELATIONSHIP_8` FOREIGN KEY (`ID_VRSTAVPISA`) REFERENCES `vrsta_vpisa` (`ID_VRSTAVPISA`),
  ADD CONSTRAINT `FK_RELATIONSHIP_9` FOREIGN KEY (`ID_NACIN`) REFERENCES `nacin_studija` (`ID_NACIN`);

--
-- Constraints for table `zeton`
--
ALTER TABLE `zeton`
  ADD CONSTRAINT `FK_LETNIK_1` FOREIGN KEY (`ID_LETNIK`) REFERENCES `letnik` (`ID_LETNIK`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_RELATIONSHIP_7` FOREIGN KEY (`ID_OSEBA`) REFERENCES `student` (`ID_OSEBA`),
  ADD CONSTRAINT `FK_STUD_LETO_1` FOREIGN KEY (`ID_STUD_LETO`) REFERENCES `studijsko_leto` (`ID_STUD_LETO`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
