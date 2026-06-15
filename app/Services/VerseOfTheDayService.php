<?php

namespace App\Services;

class VerseOfTheDayService
{
    /**
     * Curated list of Bible verses for daily rotation.
     */
    private static array $verses = [
        ['text' => 'Porque de tal manera amó Dios al mundo, que ha dado a su Hijo unigénito, para que todo aquel que en él cree, no se pierda, mas tenga vida eterna.', 'reference' => 'Juan 3:16'],
        ['text' => 'Todo lo puedo en Cristo que me fortalece.', 'reference' => 'Filipenses 4:13'],
        ['text' => 'El Señor es mi pastor; nada me faltará.', 'reference' => 'Salmo 23:1'],
        ['text' => 'Fíate de Jehová de todo tu corazón, y no te apoyes en tu propia prudencia.', 'reference' => 'Proverbios 3:5'],
        ['text' => 'Y sabemos que a los que aman a Dios, todas las cosas les ayudan a bien.', 'reference' => 'Romanos 8:28'],
        ['text' => 'Mas buscad primeramente el reino de Dios y su justicia, y todas estas cosas os serán añadidas.', 'reference' => 'Mateo 6:33'],
        ['text' => 'Bendito el varón que confía en Jehová, y cuya confianza es Jehová.', 'reference' => 'Jeremías 17:7'],
        ['text' => 'Clama a mí, y yo te responderé, y te enseñaré cosas grandes y ocultas que tú no conoces.', 'reference' => 'Jeremías 33:3'],
        ['text' => 'Esperad en él en todo tiempo, oh pueblos; derramad delante de él vuestro corazón; Dios es nuestro refugio.', 'reference' => 'Salmo 62:8'],
        ['text' => 'El amor es sufrido, es benigno; el amor no tiene envidia, el amor no es jactancioso, no se envanece.', 'reference' => '1 Corintios 13:4'],
        ['text' => 'No os afanéis por nada; sino sean conocidas vuestras peticiones delante de Dios en toda oración y ruego, con acción de gracias.', 'reference' => 'Filipenses 4:6'],
        ['text' => 'Porque yo sé los pensamientos que tengo acerca de vosotros, dice Jehová, pensamientos de paz, y no de mal.', 'reference' => 'Jeremías 29:11'],
        ['text' => 'Jehová es mi luz y mi salvación; ¿a quién temeré?', 'reference' => 'Salmo 27:1'],
        ['text' => 'Venid a mí todos los que estáis trabajados y cargados, y yo os haré descansar.', 'reference' => 'Mateo 11:28'],
        ['text' => 'Esforzaos y cobrad ánimo; no temáis, ni tengáis miedo de ellos, porque Jehová tu Dios es el que va contigo.', 'reference' => 'Deuteronomio 31:6'],
        ['text' => 'El que habita al abrigo del Altísimo morará bajo la sombra del Omnipotente.', 'reference' => 'Salmo 91:1'],
        ['text' => 'Y esta es la confianza que tenemos en él, que si pedimos alguna cosa conforme a su voluntad, él nos oye.', 'reference' => '1 Juan 5:14'],
        ['text' => 'La paz os dejo, mi paz os doy; no la que el mundo da, yo os la doy.', 'reference' => 'Juan 14:27'],
        ['text' => 'Alzaré mis ojos a los montes; ¿de dónde vendrá mi socorro? Mi socorro viene de Jehová, que hizo los cielos y la tierra.', 'reference' => 'Salmo 121:1-2'],
        ['text' => 'Mas el fruto del Espíritu es amor, gozo, paz, paciencia, benignidad, bondad, fe.', 'reference' => 'Gálatas 5:22'],
        ['text' => 'A Dios sea gloria en la iglesia en Cristo Jesús por todas las edades, por los siglos de los siglos. Amén.', 'reference' => 'Efesios 3:21'],
        ['text' => 'Con vuestra paciencia ganaréis vuestras almas.', 'reference' => 'Lucas 21:19'],
        ['text' => 'Dios es amor; y el que permanece en amor, permanece en Dios, y Dios en él.', 'reference' => '1 Juan 4:16'],
        ['text' => 'El nombre de Jehová es torre fuerte; a él correrá el justo, y será levantado.', 'reference' => 'Proverbios 18:10'],
        ['text' => 'No temas, porque yo estoy contigo; no desmayes, porque yo soy tu Dios que te esfuerzo.', 'reference' => 'Isaías 41:10'],
        ['text' => 'Este es el día que hizo Jehová; nos gozaremos y alegraremos en él.', 'reference' => 'Salmo 118:24'],
        ['text' => 'Bienaventurados los de limpio corazón, porque ellos verán a Dios.', 'reference' => 'Mateo 5:8'],
        ['text' => 'Como el padre se compadece de los hijos, se compadece Jehová de los que le temen.', 'reference' => 'Salmo 103:13'],
        ['text' => 'Y todo lo que pidiereis en oración, creyendo, lo recibiréis.', 'reference' => 'Mateo 21:22'],
        ['text' => 'Mi Dios, pues, suplirá todo lo que os falta conforme a sus riquezas en gloria en Cristo Jesús.', 'reference' => 'Filipenses 4:19'],
    ];

    public static function getToday(): array
    {
        $dayOfYear = (int) date('z'); // 0-365
        $index = $dayOfYear % count(self::$verses);
        return self::$verses[$index];
    }
}
