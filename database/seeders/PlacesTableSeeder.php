<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Place;
use App\UserCategory;
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

        $c = new UserCategory();
        $c->user_id = 1;
        $c->name = 'Unterkunft';
        $c->color = '#72a555';
        $c->order = 50;
        $c->save();
        $c_unterkunft = $c->id;

        $c = new UserCategory();
        $c->user_id = 1;
        $c->name = 'Sport & Aktivitäten';
        $c->color = '#ab62c0';
        $c->order = 40;
        $c->save();
        $c_sport = $c->id;


        $c = new UserCategory();
        $c->user_id = 1;
        $c->name = 'Kultur';
        $c->color = '#638ccc';
        $c->order = 10;
        $c->save();
        $c_kultur = $c->id;


        $p = new Place();
        $p->user_id = 1;
        $p->user_category_id = $c_kultur;
        $p->title = 'Thugga';
        $p->description = 'Thugga war eine antike Stadt im heutigen Tunesien, deren Überreste heute zum Teil freigelegt sind und zu den besterhaltenen in Nordafrika zählen. Ihre Blütezeit erlebte die Stadt als Teil der römischen Provinz Africa im 3. Jahrhundert n. Chr. Ihre Geschichte liefert jedoch auch Kenntnisse über die numidische, punische und byzantinische Zeit.';
        $p->location = new Point(36.4232907, 9.2099453);
        $p->google_place_id = 'ChIJqSqRjsyC_BIRvAhsJaCR4-0';
        $p->unesco_world_heritage = 794;
        $p->source = 'https://www.reddit.com/r/Tunisia/comments/acgfcw/the_dougga_amphitheatre/';
        $p->save();

        $p = new Place();
        $p->user_id = 1;
        $p->user_category_id = $c_kultur;
        $p->title = 'Djerbahood';
        $p->url = 'http://www.djerbahood.com/';
        $p->priority = 3;
        $p->description = 'Streetart die im ganzen Ort verteilt ist. Es gibt auch eine [Karte mit den Orten der Kunstwerke](http://itinerrance.fr/wp-content/uploads/2014/08/Plan_Djerbahood_Itinerrance.pdf).';
        $p->location = new Point(33.821312, 10.854312);
        $p->google_place_id = 'ChIJU6a4Nxq7qhMRxMlTUd_iMWA';
        $p->visited_at = '2019-02-17';
        $p->visit_review = 'Mit unter echt scchöne Graffities, bzw. Street-Art an den wänden. Auf jeden Fall einen Blick wert.';
        $p->save();

        $p = new Place();
        $p->user_id = 1;
        $p->user_category_id = $c_kultur;
        $p->title = 'Synagogue de la Ghriba (Djerba)';
        $p->priority = 4;
        $p->description = 'Die älterste Synagoge in Nordafrika, 2002 wurde ein Anschalg auf sie verübt mit mehreren Toden. Unklar, ob sich hierbei auch im die verfallene "Hara Seghira Synagoge" handelt? Wiki meint das sind die selben GPS Koordinaten.';
        $p->location = new Point(33.813937,10.859312);
        $p->visited_at = '2019-02-17';
        $p->visit_review = 'Sehr schön zu besuchen, man muss durch eine Sicherheitskontrolle um hineinzu dürfen. Links ist dann die Synagoge, rechts sind Unterkünfte für Pilger.';
        $p->google_place_id = 'ChIJ2RI8_Q67qhMRFziw07KQE_s';

        $p->save();


        $p = new Place();
        $p->user_id = 1;
        $p->user_category_id = $c_kultur;
        $p->title = 'Mos Eisley, Cantina Bar';
        $p->priority = 1;
        $p->description = 'Gebäude, bei dem angeblich die aussenasichten der Cantina bar in Star Wars gedrehrt wurde ([Star Wars Szene](https://youtu.be/2P4Q50PiGCo?t=126)).

Davon ist aber scheinbar nicht mehr wirklcih was zu sehen ([siehe](http://neokerberos.free.fr/star%20wars/moseisley.htm)). Ich denke das lohnt sich nicht.';
        $p->location = new Point(33.723937,10.750062);
        $p->google_place_id = 'ChIJiWUjO1S2qhMRMdi1ehwMIsU';
        $p->save();
        $p->attachTags(['Star Wars', 'Episode IV']);
        $p->save();

        $p = new Place();
        $p->user_id = 1;
        $p->user_category_id = $c_kultur;
        $p->title = 'Unterirdische Moschee';
        $p->priority = 4;
        $p->description = 'Wird laut Wikipedia nicht mehr genutzt und kann besichtigt werden.';
        $p->location = new Point(33.72167, 10.9119);
        $p->google_place_id = 'ChIJKbn1nd2-qhMRiEh8qE-0nL8';

        $p->visited_at = '2019-02-17';
        $p->visit_review = 'Sieht von außen spannend aus, allerdings ist es innnen einfach ein *leerer Keller* mit Tags an den Wänden. Unsere Frage ob wir als nicht muslime da rein dürfen, war wohl etwas unnötig. ;)';

        $p->save();
        $p->attachTags(['Ibaditen']);
        $p->save();


        $p = new Place();
        $p->user_id = 1;
        $p->user_category_id = $c_kultur;
        $p->title = 'Meninx (antike Stadt)';
        $p->priority = 2;
        $p->description = 'Wirklich was zu sehen gibt es hier nicht, die Stätte ist nicht erschlossen. Es liegen ein paar Fragmente im Sand.

Meninx, gr. Μῆνιγξ. War früher auch der namengeber der Insel, hatte bis zum 3 Jhdt. n. Chr. zentrale beduetung als wichtiger Purpur lieferant im Mittelmeerraum.

Bericht über den [Verfall](http://archaeologieblog.de/tunesien-meninx-djerba/) und die [Forschunggeschichte](https://www.klass-archaeologie.uni-muenchen.de/forschung/d-projekte-laufend/meninx/stadt_forschungsgeschichte/index.html).';
        $p->location = new Point(33.682812,10.919188);
        $p->google_place_id = 'ChIJMVRj0G6_qhMRFwHqEbIixQc';

        $p->visited_at = '2019-02-17';
        $p->visit_review = 'Kann man mal kurz halten wenn man möchte, aber man sieht hier nur ein paar Säulen Sockel und ein paar Steine. Ausserdem eine Zisterne, ob die noch Antik ist, weiß ich aber nicht, laut unserem Taxifahrer ja…';


        $p->save();


        $p = new Place();
        $p->user_id = 1;
        $p->user_category_id = $c_kultur;
        $p->title = 'Überreste eines Tempels?';
        $p->priority = 3;
        $p->description = 'Hier scheinen zwischen ein paar Olivenbäumen ein paar Steinchen / eine Ruine eines Tempels zu sein.

Gefunden [via](https://web.archive.org/web/20140322073933/http://www.tunesieninformationen.de/suedtunesien/djerba-und-zarzis/djerba/el-kantara-und-meninx.htm).';
        $p->location = new Point(33.699227, 10.914993);
        $p->visited_at = '2019-02-17';
        $p->visit_review = 'Sind die Übereste eines Temples. Kurzer Halt von 15min.';


        $p->save();


        $p = new Place();
        $p->user_id = 1;
        $p->user_category_id = $c_kultur;
        $p->title = 'Borj El K\'bir Fort / Ghazi Mustapha Tower';
        $p->priority = 3;
        $p->description = 'Ein Fort aus dem 15. Jhdt. Wurde auf eine ätere rönische Stadt gebaut, von der sieht man "gegenüber" (?) aber nur noch eine Zisterne.' ;
        $p->location = new Point(33.884062,10.860562);
        $p->google_place_id = 'ChIJL01n3PGkqhMRwiUZ9W3cRVc';

        $p->visited_at = '2019-02-17';
        $p->visit_review = 'War leider schon geschlossen als wit gegen 17 Uhr da waren. Man sollte sich also nicht auf die Google Maps Öffnungszeiten verlassen. ;)';

        $p->save();

        $p = new Place();
        $p->user_id = 1;
        $p->user_category_id = $c_kultur;
        $p->priority = 2;
        $p->title = 'Fort de Borj El Kastil';
        $p->description = 'Festung des Spansichen Eroberers Ruggiero di Lauria aus dem 13. Jhdt. Kann nur mit einem Gelände gängigen Fahrzeug bei Ebbe erreicht werden. Sind ein haufen steine im Sand. ;)' ;
        $p->location = new Point(33.683688,10.973937);
        $p->google_place_id = 'ChIJ35BzI-e_qhMRHKi5pkfmyII';

        $p->save();



        $p = new Place();
        $p->user_id = 1;
        $p->user_category_id = $c_kultur;
        $p->title = 'Mosque Sidi Jmor';
        $p->priority = 5;
        $p->description = 'Moschee, und/oder ein Marabout (Grabstädte eines lokalen Geistliche/Peröhnlichkeit)?

 Soll auch einen netten Strand haben und das Restaurant am Strand hat wohl lokale Kost. Nachmittags / Abends? Sonnenuntergang über dem Meer (=> Richtung Westen).

 War ausserdem die Star Wars Dreh Location für _[Tosche Stattion](http://neokerberos.free.fr/star%20wars/tosche.htm)_, dort wo Luke in IV Power converter kaufen will. Die Szenen waren aber wohl nicht im finalen Cut zu sehen ([YT Video der Szene](https://www.youtube.com/watch?v=f00IkrWvur4&t=27s)).';
        $p->location = new Point(33.831812,10.748188);
        $p->google_place_id = 'ChIJo6RlRrGxqhMRWINAnGsTx5I';

        $p->save();
        $p->attachTags(['Star Wars', 'Episode IV']);
        $p->save();


        $p = new Place();
        $p->user_id = 1;
        $p->user_category_id = $c_kultur;
        $p->title = 'Star Wars Bens Hütte (IV)';
        $p->priority = 5;
        $p->description = 'Bens Hütte aus Episode IV, wobei die Szene ab dem re-release im Jahr 1997 durch eine CGI Animation ersetzt wurde.

[Rekostruktion der Hütte](http://neokerberos.free.fr/star%20wars/benshut.htm).';
        $p->location = new Point(33.740938,10.734937);
        $p->google_place_id = 'ChIJG78Zd-22qhMRzE1Hdn9kkso';

        $p->visited_at = '2019-02-21';
        $p->visit_review = 'Toll!';



        $p->save();
        $p->attachTags(['Star Wars', 'Episode IV']);
        $p->save();



        $p = new Place();
        $p->user_id = 1;
        $p->user_category_id = $c_kultur;
        $p->title = 'Sidi Bouhlel ("Star Wars Canyon")';
        $p->description = 'Eine Schlucht, hier wurde Bens und Lukes kennenlerenen mit R2-D2 gedreht.

Weiter hinten in der Schlucht sind auch Dreheorte von _Indian Jones Raider of the Lost Ark_ und _The English Patient_.
Eine [Zusammenfassung der Drehorte mit vergleichs Bildern](https://www.youtube.com/watch?v=AGYLoaWrAeM).

Ist auch von der Natur her ganz hübsch. ;)';
        $p->location = new Point(34.033563,8.282063);
        $p->google_place_id = 'ChIJ7-GGmT7FVxIRXY9eQP5h2kg';

        $p->save();
        $p->attachTags(['Star Wars', 'Episode IV']);
        $p->save();



        $p = new Place();
        $p->user_id = 1;
        $p->user_category_id = $c_kultur;
        $p->title = 'Military Museum Of Mareth-Line';
        $p->priority = 4;
        $p->description = 'Museum über die Befestigungen der [Mareth-Line](https://de.wikipedia.org/wiki/Mareth-Linie) aus dem WW2. Unlkar ob man da mit englisch viel versteht, aber sieht fancy aus.

Rommels Führungsstand Bunker ist auch direkt daneben, aber unklar, ob das dazugehört, oder nicht.

- [Deutsche infos](https://www.tunesieninformationen.de/uebersicht/mareth/mareth.htm)
- [gefunden via](http://www.exploguide.com/site/mareth-line-military-museum-mareth)';
        $p->location = new Point(33.596187,10.311312);
        $p->google_place_id = 'ChIJtddCgk08VRIRtW8ZgS2NfWc';

        $p->save();
        $p->attachTags(['WW2']);
        $p->save();



        $p = new Place();
        $p->user_id = 1;
        $p->user_category_id = $c_kultur;
        $p->title = 'Römischen Stadt Gigthis (Giktis)';
        $p->priority = 3;
        $p->description = 'Römische Stadt. _Erwarten Sie nicht den Ausgrabungs- oder Restaurierungsstand von » Dougga zu sehen, dafür werden Sie mit einer übersichtlichen antiken Stätte in beeindruckender landschaftlicher Lage direkt am Golf von Bou Ghrara belohnt._.

[Mehr info](https://www.tunesieninformationen.de/geschichte/roemische-geschichte/gightis-giktis/gightis.htm)';
        $p->location = new Point(33.532687,10.674438);
        $p->google_place_id = 'ChIJb9hJSpjNqhMRd7Z45Ya6F34';

        $p->save();


        $p = new Place();
        $p->user_id = 1;
        $p->user_category_id = $c_kultur;
        $p->title = 'Hotel Sidi Idriss / Dreh location Lukes eltern / Berber architektur Dorf';
        $p->priority = 2;
        $p->description = 'Das ist ein [echtes Hotel](https://www.atlasobscura.com/places/hotel-sidi-driss), in dem Star Wars gedreht wurde. Diese "löcher" sind dort die übliche Bauweise. Geht wohl auf die Berber zurück.

Unklar ob es da auch führungen o.ä. gibt als Tourist zu besuch, da wohnen halt normale Leute, die es nciht so toll finden, wenn plörtzlich Touris mit Kamera im Wohnzimmer stehen.';
        $p->location = new Point(33.542687,9.967312);
        $p->google_place_id = 'ChIJvV0fQ0IGVRIRe5vMH9-HJXA';

        $p->save();
        $p->attachTags(['Berber', 'Star Wars', 'Episode IV']);
        $p->save();

        $p = new Place();
        $p->user_id = 1;
        $p->user_category_id = $c_kultur;
        $p->title = 'Musée Berbère de Tamezret';
        $p->priority = 2;
        $p->description = 'Auch ein Berberdorf, aber in die Höhe - nicht in Tiefe! ;)

Ungefähr an der GPS Location soll ein ein kleines, privates Museum über Berber Traditionen geben. Ist aber nicht auf Google Maps.

[Habe es hier gefunden](https://www.tripadvisor.de/Attraction_Review-g4108196-d7757447-Reviews-Musee_Berbere_de_Tamezret-Tamezret_Gabes_Governorate.html?m=19905), ob die GPS Location genau stimmt, weiß ich nicht.';
        $p->location = new Point(33.536907, 9.864364);
        $p->google_place_id = 'ChIJ94q1-YGpVRIRMe5Mr-QscgQ';

        $p->save();
        $p->attachTags(['Berber']);
        $p->save();


        $p = new Place();
        $p->user_id = 1;
        $p->user_category_id = $c_kultur;
        $p->title = 'Ksar Ouled Soltane';
        $p->priority = 1;
        $p->description = 'Restourierte Ksare (Berbische Bauweise für Häuser, Kornspeicher). Dieser spezielle Ksar war in Star Wars Episode I in manchen Hintergründen zu sehen.';
        $p->location = new Point(32.788437,10.514812);
        $p->google_place_id = 'ChIJAQBAOmyuVBIRThuFz26wztg';

        $p->save();
        $p->attachTags(['Berber', 'Star Wars', 'Episode I']);
        $p->save();

        $p = new Place();
        $p->user_id = 1;
        $p->user_category_id = $c_kultur;
        $p->title = 'Ksar Medenine';
        $p->priority = 3;
        $p->description = 'Anakins Zuhause in Star Wars Episode I.';
        $p->location = new Point(33.347472, 10.492083);
        $p->google_place_id = 'ChIJD_RMESnWVBIRreRkpgMnUUk';
        $p->save();
        $p->attachTags(['Berber', 'Star Wars', 'Episode I']);
        $p->save();

        $p = new Place();
        $p->user_id = 1;
        $p->user_category_id = $c_kultur;
        $p->title = 'Ksar Metameur';
        $p->priority = 3;
        $p->description = 'Ganz gut erhaltene Ksars ([Video](https://www.youtube.com/watch?v=-i3sOqlVdPo)).';
        $p->location = new Point(33.369444, 10.438889);

        $p->save();
        $p->attachTags(['Berber']);
        $p->save();


        $p = new Place();
        $p->user_id = 1;
        $p->user_category_id = $c_sport;
        $p->title = 'Djerba Golf Club';
        $p->url = 'http://www.djerbagolf.com.tn/';
        $p->priority = 3;
        $p->description = 'Man braucht schon eine Platzreife, aber es gibt wohl auch eine Driving Range.

[Reviews](http://www.1golf.eu/en/club/djerba-golf-club/)';
        $p->location = new Point(33.826188,11.011312);
        $p->google_place_id = 'ChIJ7zPaW46XqhMRE5mml0NCwBQ';

        $p->save();


        $p = new Place();
        $p->user_id = 1;
        $p->user_category_id = $c_kultur;
        $p->title = 'Guellala Museum (Volkskunde Museum über Djerba?)';
        $p->priority = 2;
        $p->description = 'Mir ist nicht so ganz klar, was das Muesum ausstellt, ich glaube so ein Mix aus Volkskunde, Geschichte, Kultur, etc. von Djerba. Die Google Reviews sind recht positiv, wobei auch viel "gut mit Kindern zu besuchen" dabei ist.';
        $p->location = new Point(33.732563,10.865687);
        $p->google_place_id = 'ChIJ6xCYZxa5qhMRpXwJba8Cw5A';

        $p->save();

        $p = new Place();
        $p->user_id = 1;
        $p->user_category_id = $c_kultur;
        $p->title = 'Chenini';
        $p->priority = 4;
        $p->description = 'Berber Dorf mit ksaren im Fels. Sind nicht mehr bewohnt, bzw. Die Bewohner wohnen seit Ende der 50er in einem "modernen" Dorf in der Nähe.';
        $p->location = new Point(32.911111, 10.261667);
        $p->google_place_id = 'ChIJBXT4M-a9VBIRm5BPXcQfPEE';


        $p->visited_at = '2019-02-21';
        $p->visit_review = 'Unser Guide sprach leider kein deutsch und Erklärungen gibt es da leider nicht, wir haben also keine Hintergruünde erklärt bekommen. Unabhänig davon aber eine Beeindruckender Anblick!';

        $p->save();
        $p->attachTags(['Berber']);
        $p->save();

        $p = new Place();
        $p->user_id = 1;
        $p->user_category_id = $c_kultur;
        $p->title = 'Mosquee des 7 Dormants';
        $p->priority = 4;
        $p->description = 'Sieht fancy aus. Reviews sagen toller Ausblick. Man soll den lokalen Guides folgen. / Braucht man um rein zu kommen?';
        $p->location = new Point(32.9099375, 10.2749375);
        $p->google_place_id = 'ChIJczFy7-69VBIRFc3vF09SSag';


        $p->visited_at = '2019-02-21';
        $p->visit_review = '';
        $p->save();


        $p = new Place();
        $p->user_id = 1;
        $p->user_category_id = $c_kultur;
        $p->title = 'Henchir Bourgou';
        $p->priority = 1;
        $p->description = 'War wohl ein Mausoleum eines numidischen Prinzen, ist leider komplett verfallen und vermuellt.

> it was recognized by scientific circles internationally for its glorious past whose origins go back to protohistory. A spectacular mausoleum-tower, built by a native prince in the 2nd century. BC. AD, arises south of the site, recalling, by its architecture, other parallels attested in Sabratha (Libya), Siga (Algeria) and Dougga (Tunisia)

[Via](http://kapitalis.com/tunisie/2015/12/29/archeologie-les-etudiants-de-liset-au-chevet-de-henchir-bourgou/)

[Video davon](https://youtu.be/LFQf-C3zsss).';
        $p->location = new Point(33.8198125, 10.9704375);
        $p->google_place_id = 'ChIJFRk8R129qhMR2ExZ7bSwlkw';

        $p->save();


        $p = new Place();
        $p->user_id = 1;
        $p->user_category_id = $c_kultur;
        $p->title = 'Fadhloun Mosque';
        $p->url = 'https://mosquee-fadhloun-djerba-midoun.business.site';
        $p->priority = 1;
        $p->description = 'Nicht mehr genutzte Mosche. Für Touristen zugänglich.';
        $p->location = new Point(33.8246875, 10.9594375);
        $p->google_place_id = 'ChIJi5wTtEC9qhMRUMnx71F7FGY';

        $p->save();


        $p = new Place();
        $p->user_id = 1;
        $p->user_category_id = $c_unterkunft;
        $p->title = 'Hotel Golf Beach';
        $p->priority = 1;
        $p->description = 'Unser Hotel auf Djerba. War Okay, der Strand ist direkt vor dem Hotel und schön. Das essen war *okay*, aber nicht überragend.

Wir waren in der Nebensaison (Februrar, 2019), das Hotel war also nicht seh voll. Ich stelle mir das Hotel sehr, sehr anstrengend vor, wenn es voll belegt ist. Da es schon groß ist, aberR Restaurant, Bars, Pool und Strand dann aber schon sehr gedrängt sein müssen, denke ich.';
        $p->location = new Point(33.772687,11.032063);
        $p->google_place_id = 'ChIJiSyDcR2YqhMRg21IH0Z26Rs';

        $p->save();


    }
}
