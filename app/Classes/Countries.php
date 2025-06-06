<?php


namespace App\Classes;


class Countries
{


    public function list()
    {
        $ISOCountryCode['UNKNOWN'] = "Unknown";
        $ISOCountryCode['AF'] = "Afghanistan";
        $ISOCountryCode['AX'] = "Åland Islands";
        $ISOCountryCode['AL'] = "Albania";
        $ISOCountryCode['DZ'] = "Algeria";
        $ISOCountryCode['AS'] = "American Samoa";
        $ISOCountryCode['AD'] = "Andorra";
        $ISOCountryCode['AO'] = "Angola";
        $ISOCountryCode['AI'] = "Anguilla";
        $ISOCountryCode['AQ'] = "Antarctica";
        $ISOCountryCode['AG'] = "Antigua and Barbuda";
        $ISOCountryCode['AR'] = "Argentina";
        $ISOCountryCode['AM'] = "Armenia";
        $ISOCountryCode['AW'] = "Aruba";
        $ISOCountryCode['AU'] = "Australia";
        $ISOCountryCode['AT'] = "Austria";
        $ISOCountryCode['AZ'] = "Azerbaijan";
        $ISOCountryCode['BS'] = "Bahamas";
        $ISOCountryCode['BH'] = "Bahrain";
        $ISOCountryCode['BD'] = "Bangladesh";
        $ISOCountryCode['BB'] = "Barbados";
        $ISOCountryCode['BY'] = "Belarus";
        $ISOCountryCode['BE'] = "Belgium";
        $ISOCountryCode['BZ'] = "Belize";
        $ISOCountryCode['BJ'] = "Benin";
        $ISOCountryCode['BM'] = "Bermuda";
        $ISOCountryCode['BT'] = "Bhutan";
        $ISOCountryCode['BO'] = "Bolivia, Plurinational State of";
        $ISOCountryCode['BQ'] = "Bonaire, Sint Eustatius and Saba";
        $ISOCountryCode['BA'] = "Bosnia and Herzegovina";
        $ISOCountryCode['BW'] = "Botswana";
        $ISOCountryCode['BV'] = "Bouvet Island";
        $ISOCountryCode['BR'] = "Brazil";
        $ISOCountryCode['BQ'] = "British Antarctic Territory";
        $ISOCountryCode['IO'] = "British Indian Ocean Territory";
        $ISOCountryCode['BN'] = "Brunei Darussalam";
        $ISOCountryCode['BG'] = "Bulgaria";
        $ISOCountryCode['BF'] = "Burkina Faso";
        $ISOCountryCode['BU'] = "Burma";
        $ISOCountryCode['BI'] = "Burundi";
        $ISOCountryCode['BY'] = "Belarus";
        $ISOCountryCode['KH'] = "Cambodia";
        $ISOCountryCode['CM'] = "Cameroon";
        $ISOCountryCode['CA'] = "Canada";
        $ISOCountryCode['CT'] = "Canton and Enderbury Islands";
        $ISOCountryCode['CV'] = "Cape Verde";
        $ISOCountryCode['KY'] = "Cayman Islands";
        $ISOCountryCode['CF'] = "Central African Republic";
        $ISOCountryCode['TD'] = "Chad";
        $ISOCountryCode['CL'] = "Chile";
        $ISOCountryCode['CN'] = "China";
        $ISOCountryCode['CX'] = "Christmas Island";
        $ISOCountryCode['CC'] = "Cocos (Keeling) Islands";
        $ISOCountryCode['CO'] = "Colombia";
        $ISOCountryCode['KM'] = "Comoros";
        $ISOCountryCode['CG'] = "Congo";
        $ISOCountryCode['CD'] = "Congo (the Democratic Republic of the)";
        $ISOCountryCode['CK'] = "Cook Islands";
        $ISOCountryCode['CR'] = "Costa Rica";
        $ISOCountryCode['CI'] = "Côte d’Ivoire";
        $ISOCountryCode['HR'] = "Croatia";
        $ISOCountryCode['CU'] = "Cuba";
        $ISOCountryCode['CW'] = "Curaçao";
        $ISOCountryCode['CY'] = "Cyprus";
        $ISOCountryCode['CZ'] = "Czech Republic";
        $ISOCountryCode['CS'] = "Czechoslovakia";
        $ISOCountryCode['DY'] = "Dahomey";
        $ISOCountryCode['DK'] = "Denmark";
        $ISOCountryCode['DJ'] = "Djibouti";
        $ISOCountryCode['DM'] = "Dominica";
        $ISOCountryCode['DO'] = "Dominican Republic";
        $ISOCountryCode['NQ'] = "Dronning Maud Land";
        $ISOCountryCode['TP'] = "East Timor";
        $ISOCountryCode['EC'] = "Ecuador";
        $ISOCountryCode['EG'] = "Egypt";
        $ISOCountryCode['SV'] = "El Salvador";
        $ISOCountryCode['GQ'] = "Equatorial Guinea";
        $ISOCountryCode['ER'] = "Eritrea";
        $ISOCountryCode['EE'] = "Estonia";
        $ISOCountryCode['ET'] = "Ethiopia";
        $ISOCountryCode['FK'] = "Falkland Islands [Malvinas]";
        $ISOCountryCode['FO'] = "Faroe Islands";
        $ISOCountryCode['FJ'] = "Fiji";
        $ISOCountryCode['FI'] = "Finland";
        $ISOCountryCode['FR'] = "France";
        $ISOCountryCode['FX'] = "France, Metropolitan";
        $ISOCountryCode['AI'] = "French Afars and Issas";
        $ISOCountryCode['GF'] = "French Guiana";
        $ISOCountryCode['PF'] = "French Polynesia";
        $ISOCountryCode['FQ'] = "French Southern and Antarctic Territories";
        $ISOCountryCode['TF'] = "French Southern Territories";
        $ISOCountryCode['GA'] = "Gabon";
        $ISOCountryCode['GM'] = "Gambia";
        $ISOCountryCode['GE'] = "Georgia";
        $ISOCountryCode['DD'] = "German Democratic Republic";
        $ISOCountryCode['DE'] = "Germany";
        $ISOCountryCode['GH'] = "Ghana";
        $ISOCountryCode['GI'] = "Gibraltar";
        $ISOCountryCode['GR'] = "Greece";
        $ISOCountryCode['GL'] = "Greenland";
        $ISOCountryCode['GD'] = "Grenada";
        $ISOCountryCode['GP'] = "Guadeloupe";
        $ISOCountryCode['GU'] = "Guam";
        $ISOCountryCode['GT'] = "Guatemala";
        $ISOCountryCode['GG'] = "Guernsey";
        $ISOCountryCode['GN'] = "Guinea";
        $ISOCountryCode['GW'] = "Guinea-Bissau";
        $ISOCountryCode['GY'] = "Guyana";
        $ISOCountryCode['HT'] = "Haiti";
        $ISOCountryCode['HM'] = "Heard Island and McDonald Islands";
        $ISOCountryCode['VA'] = "Holy See [Vatican City State]";
        $ISOCountryCode['HN'] = "Honduras";
        $ISOCountryCode['HK'] = "Hong Kong";
        $ISOCountryCode['HU'] = "Hungary";
        $ISOCountryCode['IS'] = "Iceland";
        $ISOCountryCode['IN'] = "India";
        $ISOCountryCode['ID'] = "Indonesia";
        $ISOCountryCode['IR'] = "Iran";
        $ISOCountryCode['IQ'] = "Iraq";
        $ISOCountryCode['IE'] = "Ireland";
        $ISOCountryCode['IM'] = "Isle of Man";
        $ISOCountryCode['IL'] = "Israel";
        $ISOCountryCode['IT'] = "Italy";
        $ISOCountryCode['JM'] = "Jamaica";
        $ISOCountryCode['JP'] = "Japan";
        $ISOCountryCode['JE'] = "Jersey";
        $ISOCountryCode['JT'] = "Johnston Island";
        $ISOCountryCode['JO'] = "Jordan";
        $ISOCountryCode['KZ'] = "Kazakhstan";
        $ISOCountryCode['KE'] = "Kenya";
        $ISOCountryCode['KI'] = "Kiribati";
        $ISOCountryCode['KP'] = "Korea (the Democratic People's Republic of)";
        $ISOCountryCode['KR'] = "Korea (the Republic of)";
        $ISOCountryCode['KW'] = "Kuwait";
        $ISOCountryCode['KG'] = "Kyrgyzstan";
        $ISOCountryCode['LA'] = "Lao People's Democratic Republic";
        $ISOCountryCode['LV'] = "Latvia";
        $ISOCountryCode['LB'] = "Lebanon";
        $ISOCountryCode['LS'] = "Lesotho";
        $ISOCountryCode['LR'] = "Liberia";
        $ISOCountryCode['LY'] = "Libya";
        $ISOCountryCode['LI'] = "Liechtenstein";
        $ISOCountryCode['LT'] = "Lithuania";
        $ISOCountryCode['LU'] = "Luxembourg";
        $ISOCountryCode['MO'] = "Macao";
        $ISOCountryCode['MK'] = "Macedonia (the former Yugoslav Republic of)";
        $ISOCountryCode['MG'] = "Madagascar";
        $ISOCountryCode['MW'] = "Malawi";
        $ISOCountryCode['MY'] = "Malaysia";
        $ISOCountryCode['MV'] = "Maldives";
        $ISOCountryCode['ML'] = "Mali";
        $ISOCountryCode['MT'] = "Malta";
        $ISOCountryCode['MH'] = "Marshall Islands";
        $ISOCountryCode['MQ'] = "Martinique";
        $ISOCountryCode['MR'] = "Mauritania";
        $ISOCountryCode['MU'] = "Mauritius";
        $ISOCountryCode['YT'] = "Mayotte";
        $ISOCountryCode['MX'] = "Mexico";
        $ISOCountryCode['FM'] = "Micronesia (the Federated States of)";
        $ISOCountryCode['MI'] = "Midway Islands";
        $ISOCountryCode['MD'] = "Moldova (the Republic of)";
        $ISOCountryCode['MC'] = "Monaco";
        $ISOCountryCode['MN'] = "Mongolia";
        $ISOCountryCode['ME'] = "Montenegro";
        $ISOCountryCode['MS'] = "Montserrat";
        $ISOCountryCode['MA'] = "Morocco";
        $ISOCountryCode['MZ'] = "Mozambique";
        $ISOCountryCode['MM'] = "Myanmar";
        $ISOCountryCode['NA'] = "Namibia";
        $ISOCountryCode['NR'] = "Nauru";
        $ISOCountryCode['NP'] = "Nepal";
        $ISOCountryCode['NL'] = "Netherlands";
        $ISOCountryCode['AN'] = "Netherlands Antilles";
        $ISOCountryCode['NT'] = "Neutral Zone";
        $ISOCountryCode['NC'] = "New Caledonia";
        $ISOCountryCode['NH'] = "New Hebrides";
        $ISOCountryCode['NZ'] = "New Zealand";
        $ISOCountryCode['NI'] = "Nicaragua";
        $ISOCountryCode['NE'] = "Niger";
        $ISOCountryCode['NG'] = "Nigeria";
        $ISOCountryCode['NU'] = "Niue";
        $ISOCountryCode['NF'] = "Norfolk Island";
        $ISOCountryCode['MP'] = "Northern Mariana Islands";
        $ISOCountryCode['NO'] = "Norway";
        $ISOCountryCode['OM'] = "Oman";
        $ISOCountryCode['PC'] = "Pacific Islands (Trust Territory)";
        $ISOCountryCode['PK'] = "Pakistan";
        $ISOCountryCode['PW'] = "Palau";
        $ISOCountryCode['PS'] = "Palestine, State of";
        $ISOCountryCode['PA'] = "Panama";
        $ISOCountryCode['PZ'] = "Panama Canal Zone";
        $ISOCountryCode['PG'] = "Papua New Guinea";
        $ISOCountryCode['PY'] = "Paraguay";
        $ISOCountryCode['PE'] = "Peru";
        $ISOCountryCode['PH'] = "Philippines";
        $ISOCountryCode['PN'] = "Pitcairn";
        $ISOCountryCode['PL'] = "Poland";
        $ISOCountryCode['PT'] = "Portugal";
        $ISOCountryCode['PR'] = "Puerto Rico";
        $ISOCountryCode['QA'] = "Qatar";
        $ISOCountryCode['RE'] = "Réunion";
        $ISOCountryCode['RO'] = "Romania";
        $ISOCountryCode['RU'] = "Russian Federation";
        $ISOCountryCode['RW'] = "Rwanda";
        $ISOCountryCode['BL'] = "Saint Barthélemy";
        $ISOCountryCode['SH'] = "Saint Helena, Ascension and Tristan da Cunha";
        $ISOCountryCode['KN'] = "Saint Kitts and Nevis";
        $ISOCountryCode['LC'] = "Saint Lucia";
        $ISOCountryCode['MF'] = "Saint Martin (French part)";
        $ISOCountryCode['PM'] = "Saint Pierre and Miquelon";
        $ISOCountryCode['VC'] = "Saint Vincent and the Grenadines";
        $ISOCountryCode['WS'] = "Samoa";
        $ISOCountryCode['SM'] = "San Marino";
        $ISOCountryCode['ST'] = "Sao Tome and Principe";
        $ISOCountryCode['SA'] = "Saudi Arabia";
        $ISOCountryCode['SN'] = "Senegal";
        $ISOCountryCode['RS'] = "Serbia";
        $ISOCountryCode['CS'] = "Serbia and Montenegro";
        $ISOCountryCode['SC'] = "Seychelles";
        $ISOCountryCode['SL'] = "Sierra Leone";
        $ISOCountryCode['SK'] = "Sikkim";
        $ISOCountryCode['SG'] = "Singapore";
        $ISOCountryCode['SX'] = "Sint Maarten (Dutch part)";
        $ISOCountryCode['SK'] = "Slovakia";
        $ISOCountryCode['SI'] = "Slovenia";
        $ISOCountryCode['SB'] = "Solomon Islands";
        $ISOCountryCode['SO'] = "Somalia";
        $ISOCountryCode['ZA'] = "South Africa";
        $ISOCountryCode['GS'] = "South Georgia and the South Sandwich Islands";
        $ISOCountryCode['SS'] = "South Sudan ";
        $ISOCountryCode['RH'] = "Southern Rhodesia";
        $ISOCountryCode['ES'] = "Spain";
        $ISOCountryCode['LK'] = "Sri Lanka";
        $ISOCountryCode['SD'] = "Sudan";
        $ISOCountryCode['SR'] = "Suriname";
        $ISOCountryCode['SJ'] = "Svalbard and Jan Mayen";
        $ISOCountryCode['SZ'] = "Swaziland";
        $ISOCountryCode['SE'] = "Sweden";
        $ISOCountryCode['CH'] = "Switzerland";
        $ISOCountryCode['SY'] = "Syrian Arab Republic";
        $ISOCountryCode['TW'] = "Taiwan";
        $ISOCountryCode['TJ'] = "Tajikistan";
        $ISOCountryCode['TZ'] = "Tanzania, United Republic of";
        $ISOCountryCode['TH'] = "Thailand";
        $ISOCountryCode['TL'] = "Timor-Leste";
        $ISOCountryCode['TG'] = "Togo";
        $ISOCountryCode['TK'] = "Tokelau";
        $ISOCountryCode['TO'] = "Tonga";
        $ISOCountryCode['TT'] = "Trinidad and Tobago";
        $ISOCountryCode['TN'] = "Tunisia";
        $ISOCountryCode['TR'] = "Turkey";
        $ISOCountryCode['TM'] = "Turkmenistan";
        $ISOCountryCode['TC'] = "Turks and Caicos Islands";
        $ISOCountryCode['TV'] = "Tuvalu";
        $ISOCountryCode['UG'] = "Uganda";
        $ISOCountryCode['UA'] = "Ukraine";
        $ISOCountryCode['AE'] = "United Arab Emirates";
        $ISOCountryCode['GB'] = "United Kingdom";
        $ISOCountryCode['US'] = "United States";
        $ISOCountryCode['UM'] = "United States Minor Outlying Islands";
        $ISOCountryCode['PU'] = "United States Miscellaneous Pacific Islands";
        $ISOCountryCode['HV'] = "Upper Volta";
        $ISOCountryCode['UY'] = "Uruguay";
        $ISOCountryCode['SU'] = "USSR";
        $ISOCountryCode['UZ'] = "Uzbekistan";
        $ISOCountryCode['VU'] = "Vanuatu";
        $ISOCountryCode['VE'] = "Venezuela, Bolivarian Republic of ";
        $ISOCountryCode['VN'] = "Viet Nam";
        $ISOCountryCode['VD'] = "Viet-Nam, Democratic Republic of";
        $ISOCountryCode['VG'] = "Virgin Islands (British)";
        $ISOCountryCode['VI'] = "Virgin Islands (U.S.)";
        $ISOCountryCode['WK'] = "Wake Island";
        $ISOCountryCode['WF'] = "Wallis and Futuna";
        $ISOCountryCode['EH'] = "Western Sahara";
        $ISOCountryCode['XK'] = "Kosovo";
        $ISOCountryCode['YE'] = "Yemen";
        $ISOCountryCode['YD'] = "Yemen, Democratic";
        $ISOCountryCode['YU'] = "Yugoslavia";
        $ISOCountryCode['ZR'] = "Zaire";
        $ISOCountryCode['ZM'] = "Zambia";
        $ISOCountryCode['ZW'] = "Zimbabwe";

        return $ISOCountryCode;
    }
}
