<?php

use Illuminate\Database\Seeder;

use App\Place;
use Grimzy\LaravelMysqlSpatial\Types\Point;


class PlacesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $p = new Place();
        $p->user_id = 1;
        $p->title = 'Thugga';
        $p->description = 'Thugga war eine antike Stadt im heutigen Tunesien, deren Überreste heute zum Teil freigelegt sind und zu den besterhaltenen in Nordafrika zählen. Ihre Blütezeit erlebte die Stadt als Teil der römischen Provinz Africa im 3. Jahrhundert n. Chr. Ihre Geschichte liefert jedoch auch Kenntnisse über die numidische, punische und byzantinische Zeit.';
        $p->location = new Point(36.4232907, 9.2099453);
        $p->save();

        $p = new Place();
        $p->user_id = 1;
        $p->title = 'Djerbahood';
        $p->url = 'http://www.djerbahood.com/';
        $p->priority = 3;
        $p->description = 'Streetart die im ganzen Ort verteilt ist. Es gibt auch eine [Karte mit den Orten der Kunstwerke](http://itinerrance.fr/wp-content/uploads/2014/08/Plan_Djerbahood_Itinerrance.pdf).';
        $p->location = new Point(33.821312, 10.854312);
        $p->save();

        $p = new Place();
        $p->user_id = 1;
        $p->title = 'Synagogue de la Ghriba (Djerba)';
        $p->priority = 4;
        $p->description = 'Synagoge aus dem Ende des 19. Jhdt. Eine der ätesten in Nordafrika, 2002 wurde ein Anschalg auf sie verübt mit mehreren Toden. Unklar, ob sich hierbei auch im die verfallene "Hara Seghira Synagoge" handelt? Wiki meint das sind die selben GPS Koordinaten.';
        $p->location = new Point(33.813937,10.859312);
        $p->save();


        $p = new Place();
        $p->user_id = 1;
        $p->title = 'Mos Eisley, Cantina Bar';
        $p->priority = 1;
        $p->description = 'Gebäude, bei dem angeblich die aussenasichten der Cantina bar in Star Wars gedrehrt wurde ([Star Wars Szene](https://youtu.be/2P4Q50PiGCo?t=126)).

Davon ist aber scheinbar nicht mehr wirklcih was zu sehen ([siehe](http://neokerberos.free.fr/star%20wars/moseisley.htm)). Ich denke das lohnt sich nicht.';
        $p->location = new Point(33.723937,10.750062);
        $p->save();


        $p = new Place();
        $p->user_id = 1;
        $p->title = 'Unterirdische Moschee';
        $p->priority = 4;
        $p->description = 'Wird laut Wikipedia nicht mehr genutzt und kann besichtigt werden.';
        $p->location = new Point(33.72167, 10.9119);
        $p->save();


        $p = new Place();
        $p->user_id = 1;
        $p->title = 'Meninx (antike Stadt)';
        $p->priority = 2;
        $p->description = 'Wirklich was zu sehen gibt es hier nicht, die Städte ist nicht erschlossen. Es liegen ein paar Fragmente im Sand.';
        $p->location = new Point(33.682812,10.919188);
        $p->save();


        $p = new Place();
        $p->user_id = 1;
        $p->title = 'Überreste eines Tempels?';
        $p->priority = 3;
        $p->description = 'Hier scheinen zwischen ein paar Olivenbäumen ein paar Steinchen / eine Ruine eines Tempels zu sein.

        Gefunden [via](https://web.archive.org/web/20140322073933/http://www.tunesieninformationen.de/suedtunesien/djerba-und-zarzis/djerba/el-kantara-und-meninx.htm).';
        $p->location = new Point(33.699227, 10.914993);
        $p->save();


        $p = new Place();
        $p->user_id = 1;
        $p->title = 'Borj El K\'bir Fort / Ghazi Mustapha Tower';
        $p->priority = 3;
        $p->description = 'Ein Fort aus dem 15. Jhdt. Wurde auf eine ätere rönische Stadt gebaut, von der sieht man "gegenüber" (?) aber nur noch eine Zisterne.' ;
        $p->location = new Point(33.884062,10.860562);
        $p->save();

        $p = new Place();
        $p->user_id = 1;
        $p->priority = 2;
        $p->title = 'Fort de Borj El Kastil';
        $p->description = 'Festung des Spansichen Eroberers Ruggiero di Lauria aus dem 13. Jhdt. Kann nur mit einem Gelände gängigen Fahrzeug bei Ebbe erreicht werden. Sind ein haufen steine im Sand. ;)' ;
        $p->location = new Point(33.683688,10.973937);
        $p->save();



        $p = new Place();
        $p->user_id = 1;
        $p->title = 'Mosque Sidi Jmor';
        $p->priority = 5;
        $p->description = 'Moschee, und/oder ein Marabout (Grabstädte eines lokalen Geistliche/Peröhnlichkeit)?

 Soll auch einen netten Strand haben und das Restaurant am Strand hat wohl lokale Kost. Nachmittags / Abends? Sonnenuntergang über dem Meer (=> Richtung Westen).

 War ausserdem die Star Wars Dreh Location für _[Tosche Stattion](http://neokerberos.free.fr/star%20wars/tosche.htm)_, dort wo Luke in IV Power converter kaufen will. Die Szenen waren aber wohl nicht im finalen Cut zu sehen ([YT Video der Szene](https://www.youtube.com/watch?v=f00IkrWvur4&t=27s)).';
        $p->location = new Point(33.831812,10.748188);
        $p->save();


        $p = new Place();
        $p->user_id = 1;
        $p->title = 'Star Wars Bens Hütte (IV)';
        $p->priority = 5;
        $p->description = 'Bens Hütte aus Episode IV.

[Rekostruktion der Hütte](http://neokerberos.free.fr/star%20wars/benshut.htm).';
        $p->location = new Point(33.740938,10.734937);
        $p->save();



        $p = new Place();
        $p->user_id = 1;
        $p->title = 'Sidi Bouhlel ("Star Wars Canyon")';
        $p->description = 'Eine Schlucht, hier wurde Bens und Lukes kennenlerenen mit R2-D2 gedreht.

Weiter hinten in der Schlucht sind auch Dreheorte von _Indian Jones Raider of the Lost Ark_ und _The English Patient_.
Eine [Zusammenfassung der Drehorte mit vergleichs Bildern](https://www.youtube.com/watch?v=AGYLoaWrAeM).

Ist auch von der Natur her ganz hübsch. ;)';
        $p->location = new Point(34.033563,8.282063);
        $p->save();



        $p = new Place();
        $p->user_id = 1;
        $p->title = 'Military Museum Of Mareth-Line';
        $p->priority = 4;
        $p->description = 'Museum über die Befestigungen der [Mareth-Line](https://de.wikipedia.org/wiki/Mareth-Linie) aus dem WW2. Unlkar ob man da mit englisch viel versteht, aber sieht fancy aus.

Rommels Führungsstand Bunker ist auch direkt daneben, aber unklar, ob das dazugehört, oder nicht.

Merh Info: [http://www.exploguide.com/site/mareth-line-military-museum-mareth](http://www.exploguide.com/site/mareth-line-military-museum-mareth).
        ';
        $p->location = new Point(33.596187,10.311312);
        $p->save();



        $p = new Place();
        $p->user_id = 1;
        $p->title = 'Römischen Stadt Gigthis (Giktis)';
        $p->priority = 3;
        $p->description = 'Römische Stadt. _Erwarten Sie nicht den Ausgrabungs- oder Restaurierungsstand von » Dougga zu sehen, dafür werden Sie mit einer übersichtlichen antiken Stätte in beeindruckender landschaftlicher Lage direkt am Golf von Bou Ghrara belohnt._.

[Mehr info](https://web.archive.org/web/20131013102519/http://www.tunesieninformationen.de/geschichte/roemische-geschichte/gightis-giktis/index.htm)';
        $p->location = new Point(33.532687,10.674438);
        $p->save();






    }
}
