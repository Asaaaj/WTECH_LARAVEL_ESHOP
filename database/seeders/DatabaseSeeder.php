<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Image;
use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::truncate();
        Image::truncate();
        Product::truncate();

        User::create([
            'name' => 'Admin Používateľ',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin'),
            'phone_number' => '+421900123456',
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Bežný Používateľ',
            'email' => 'user@example.com',
            'password' => Hash::make('user'),
            'phone_number' => '+421900654321',
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);

        $products = [
            [
                'name' => 'Radiátor',
                'description' => 'Radiátor je dôležitou súčasťou kúrenia vášho domu alebo iných budov. Poskytuje tepelnú ' .
                'energiu, ktorá vám umožňuje udržiavať príjemnú teplotu vo vnútri aj v chladných mesiacoch.' .
                ' Naše radiátory sú navrhnuté s ohľadom na efektivitu a spoľahlivosť, čo zaručuje' .
                ' optimálne vykurovanie a pohodlné prostredie pre vás a vašu rodinu.',
                'price' => 79.99,
                'stock' => 50,
                'type' => 'Kúrenie',
            ],
            [
                'name' => 'Sifón',
                'description' => 'Sifón umývadla je dôležitým komponentom vašej kúpeľne alebo kuchyne,' .
                ' ktorý pomáha odvádzať odpadovú vodu a zabraňuje nepríjemným zápachom. Vyrobený z kvalitných ' .
                'materiálov ako je napríklad nerezová oceľ, PVC alebo plast, zabezpečuje spoľahlivú a dlhodobú funkciu.',
                'price' => 29.99,
                'stock' => 70,
                'type' => 'Voda',
            ],
            [
                'name' => 'Plynomer',
                'description' => 'Plynomer je nevyhnutnou súčasťou v priemyselnej oblasti, ale vie byť užitočný aj v domácnosti.' .
                ' Pomáha vám merať a kontrolovať spotrebu plynu, čo vám umožňuje efektívne riadiť náklady a' .
                ' plánovať budúce potreby. Naše plynomery sú vyrobené z kvalitných materiálov, aby poskytovali' .
                ' spoľahlivé výsledky a dlhú životnosť.',
                'price' => 49.99,
                'stock' => 100,
                'type' => 'Plyn',
            ],
            [
                'name' => 'Termostatická hlavica',
                'description' => 'Termostatická hlavica je dôležitým príslušenstvom k radiátorom, ktoré umožňuje ' .
                                 'presné nastavenie teploty v jednotlivých miestnostiach. S modernými termostatmi ' .
                                 'môžete efektívne regulovať vykurovanie a šetriť energiu.',
                'price' => 14.99,
                'stock' => 30,
                'type' => 'Kúrenie',
            ],
            [
                'name' => 'Vodovodný ventil',
                'description' => 'Vodovodný ventil je súčasťou vodovodného systému, ktorý umožňuje uzatvárať ' .
                                 'alebo otvárať prívod vody do jednotlivých zariadení. Kvalitný ventil zabezpečuje ' .
                                 'spojitosť a bezpečnosť vášho vodovodného systému.',
                'price' => 9.99,
                'stock' => 25,
                'type' => 'Voda',
            ],
            [
                'name' => 'Plynový kotol',
                'description' => 'Plynový kotol je efektívne a spoľahlivé zariadenie na vykurovanie domu alebo ' .
                                 'iných priestorov. S modernými technológiami poskytuje komfortné vykurovanie ' .
                                 'a zároveň šetrí energiu.',
                'price' => 899.99,
                'stock' => 10,
                'type' => 'Plyn',
            ],
            [
                'name' => 'Teplovodný ohrievač',
                'description' => 'Teplovodný ohrievač je ideálnym riešením pre ohrev vody v domácnosti alebo ' .
                                 'v malých prevádzkach. S rôznymi kapacitami a možnosťami inštalácie ' .
                                 'poskytuje flexibilné a spoľahlivé riešenie pre vaše potreby.',
                'price' => 399.99,
                'stock' => 15,
                'type' => 'Voda',
            ],
            [
                'name' => 'Plynový varný sporák',
                'description' => 'Plynový varný sporák je nevyhnutnou súčasťou kuchyne pre rýchle a efektívne ' .
                                 'varenie. S modernými funkciami a bezpečnostnými prvokmi poskytuje spoľahlivý ' .
                                 'a pohodlný spôsob prípravy jedál.',
                'price' => 159.99,
                'stock' => 20,
                'type' => 'Plyn',
            ],
            [
                'name' => 'Radiátorový ventilátor',
                'description' => 'Radiátorový ventilátor je príslušenstvom k radiátorom, ktoré zlepšuje distribúciu ' .
                                 'tepla v miestnostiach. Pomocou ventilátora dokážete rýchlo a efektívne vykurovať ' .
                                 'a zároveň šetriť energiu.',
                'price' => 34.99,
                'stock' => 12,
                'type' => 'Kúrenie',
            ],
            [
                'name' => 'Vodovodná batéria',
                'description' => 'Vodovodná batéria je dôležitým zariadením pre zabezpečenie tlaku a toku vody v ' .
                                 'vašej domácnosti alebo prevádzke. Spoľahlivá a výkonná vodovodná batéria ' .
                                 'zabezpečuje konzistentný prívod vody pre vaše potreby.',
                'price' => 129.99,
                'stock' => 18,
                'type' => 'Voda',
            ],
        ];

        foreach ($products as $key => $productData) {
            $product = Product::create($productData);
        }

        $imageData = [
            ['name' => 'radiator1.jpg', 'product_id' => 1], 
            ['name' => 'sifon1.jpg', 'product_id' => 2],
            ['name' => 'sifon2.jpg', 'product_id' => 2],
            ['name' => 'plynomer1.jpg', 'product_id' => 3],
            ['name' => 'termostaticka_hlavica1.jpg', 'product_id' => 4], 
            ['name' => 'vodovodny_ventil1.jpg', 'product_id' => 5],
            ['name' => 'plynovy_kotol1.jpg', 'product_id' => 6],
            ['name' => 'teplovodny_ohrievac1.jpg', 'product_id' => 7],
            ['name' => 'plynovy_varny_sporak1.jpg', 'product_id' => 8],
            ['name' => 'radiatorovy_ventilator1.jpg', 'product_id' => 9],
            ['name' => 'vodovodna_bateria1.jpg', 'product_id' => 10],
        ];

        foreach ($imageData as $data) {
            $image = new Image();
            $image->name = $data['name'];
            $image->url = 'http://localhost:8000/images/' . $data['name'];
            $image->product_id = $data['product_id'];
            $image->save();
        }
    }
}
