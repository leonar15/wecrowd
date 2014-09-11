<?php

/*
 * Helper for creating demo data
 *
 */
class Demo {

    public static $first_names = array(
        'Otilia'
        ,'Reynaldo'
        ,'Elza'
        ,'Tasha'
        ,'Gustavo'
        ,'Nisha'
        ,'Alessandra'
        ,'Bobette'
        ,'George'
        ,'Leonore'
        ,'Blanche'
        ,'Sonja'
        ,'Kandis'
        ,'Shani'
        ,'Thomasina'
        ,'Roseanna'
        ,'Gayle'
        ,'Al'
        ,'Regine'
        ,'Ida'
        ,'Ferne'
        ,'Isaura'
        ,'Abdul'
        ,'Rossana'
        ,'Kristian'
        ,'Quintin'
        ,'Brooks'
        ,'Danica'
        ,'Hedy'
        ,'Cammy'
        ,'Kalyn'
        ,'Lewis'
        ,'Hunter'
        ,'Mirtha'
        ,'Sherita'
        ,'Derrick'
        ,'Winter'
        ,'Richie'
        ,'Wynona'
        ,'Hershel'
        ,'Kendall'
        ,'Franchesca'
        ,'Justine'
        ,'Carmelina'
        ,'Sarita'
        ,'Nicolasa'
        ,'Trinity'
        ,'Joie'
        ,'Londa'
        ,'Carmon'
    );

    public static $last_names = array(
        'Lane'
        ,'Black'
        ,'Hodge'
        ,'Nicholson'
        ,'Barr'
        ,'Li'
        ,'Bond'
        ,'Roberts'
        ,'Hahn'
        ,'Gardner'
        ,'Braun'
        ,'Baird'
        ,'Rodriguez'
        ,'Koch'
        ,'Santos'
        ,'Kaiser'
        ,'Henry'
        ,'Fry'
        ,'Whitney'
        ,'Leon'
        ,'House'
        ,'Duffy'
        ,'Cantu'
        ,'Browning'
        ,'Mejia'
        ,'Craig'
        ,'Hardy'
        ,'Raymond'
        ,'Mahoney'
        ,'Fisher'
        ,'Brown'
        ,'Stuart'
        ,'Harrison'
        ,'Ferguson'
        ,'Wood'
        ,'Potts'
        ,'Austin'
        ,'Medina'
        ,'Macias'
        ,'Shepherd'
        ,'Burke'
        ,'Wells'
        ,'Mccarty'
        ,'Ryan'
        ,'West'
        ,'Sampson'
        ,'Gilmore'
        ,'Fitzgerald'
        ,'Contreras'
        ,'Webster'
    );

    public static $campaigns = array(
        array(
            'Help Jimmy get to Disneyland!',
            'Lippman, on the other hand, entertains the possibility. She recalls a few stories from her son\'s infancy, however, that provide fodder for speculation. A prominent symptom of autism is an oversensitivity to noises and colors, and Lippman recalls two anecdotes that stand out in this regard.',
        ),
        array(
            'Jerry the cat needs your help',
            'Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero. Its words and letters have been changed by addition or removal, so to deliberately render its content nonsensical; it\'s not genuine, correct, or comprehensible Latin anymore. While lorem ipsum\'s still resembles classical Latin, it actually has no meaning whatsoever. As Cicero\'s text doesn\'t contain the letters K, W, or Z, alien to latin, these, and others are often inserted randomly to mimic the typographic appearence of European languages, as are digraphs not to be found in the original.',
        ),
        array(
            'My dream comes true',
            'Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasize design elements over content. It\'s also called placeholder (or filler) text. It\'s a convenient tool for mock-ups. It helps to outline the visual elements of a document or presentation, eg typography, font, or layout. ',
        ),
    );

    public static function getFirstName() {

        return self::$first_names[array_rand(self::$first_names)];
    }

    public static function getLastName() {

        return self::$last_names[array_rand(self::$last_names)];
    }
    
    public static function getCamapaignDetails() {
        
        $campaign = self::$campaigns[array_rand(self::$campaigns)];
        return array(
            'name'        => $campaign[0],
            'description' => $campaign[1],
        );
    }
}