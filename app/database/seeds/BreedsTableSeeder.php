<?php

class BreedsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('breeds')->delete();
        
		\DB::table('breeds')->insert(array (
			0 => 
			array (
				'id' => 1,
				'name' => 'Affenpinscher',
				'size' => 'S',
			),
			1 => 
			array (
				'id' => 2,
				'name' => 'Afghan Hound',
				'size' => 'L',
			),
			2 => 
			array (
				'id' => 3,
				'name' => 'African Wild Dog',
				'size' => 'M',
			),
			3 => 
			array (
				'id' => 4,
				'name' => 'Africanis',
				'size' => 'M',
			),
			4 => 
			array (
				'id' => 5,
				'name' => 'Aidi',
				'size' => 'M',
			),
			5 => 
			array (
				'id' => 6,
				'name' => 'Airedale Terrier',
				'size' => 'S',
			),
			6 => 
			array (
				'id' => 7,
				'name' => 'Akbash Dog',
				'size' => 'L',
			),
			7 => 
			array (
				'id' => 8,
				'name' => 'Alano Espanol',
				'size' => 'L',
			),
			8 => 
			array (
				'id' => 9,
				'name' => 'Alapaha Blue Blood Bulldog',
				'size' => 'M',
			),
			9 => 
			array (
				'id' => 10,
				'name' => 'Alaskan Husky',
				'size' => 'L',
			),
			10 => 
			array (
				'id' => 11,
				'name' => 'Alaskan Klee Kai',
				'size' => 'M',
			),
			11 => 
			array (
				'id' => 12,
				'name' => 'Alaskan Malamute',
				'size' => 'L',
			),
			12 => 
			array (
				'id' => 13,
				'name' => 'Alopekis',
				'size' => 'S',
			),
			13 => 
			array (
				'id' => 14,
				'name' => 'American Akita',
				'size' => 'L',
			),
			14 => 
			array (
				'id' => 15,
				'name' => 'American Bulldog',
				'size' => 'L',
			),
			15 => 
			array (
				'id' => 16,
				'name' => 'American Cocker Spaniel',
				'size' => 'M',
			),
			16 => 
			array (
				'id' => 17,
				'name' => 'American Eskimo Dog',
				'size' => 'M',
			),
			17 => 
			array (
				'id' => 18,
				'name' => 'American Foxhound',
				'size' => 'L',
			),
			18 => 
			array (
				'id' => 19,
				'name' => 'American Hairless Terrier',
				'size' => 'S',
			),
			19 => 
			array (
				'id' => 20,
				'name' => 'American Mastiff',
				'size' => 'L',
			),
			20 => 
			array (
				'id' => 21,
				'name' => 'American Pit Bull Terrier',
				'size' => 'M',
			),
			21 => 
			array (
				'id' => 22,
				'name' => 'American Staffordshire Terrier',
				'size' => 'M',
			),
			22 => 
			array (
				'id' => 23,
				'name' => 'American Staghound',
				'size' => 'L',
			),
			23 => 
			array (
				'id' => 24,
				'name' => 'American Water Spaniel',
				'size' => 'M',
			),
			24 => 
			array (
				'id' => 25,
				'name' => 'American White Shepherd',
				'size' => 'M',
			),
			25 => 
			array (
				'id' => 26,
				'name' => 'Anatolian Shepherd Dog',
				'size' => 'L',
			),
			26 => 
			array (
				'id' => 27,
				'name' => 'Andalusian Hound',
				'size' => 'M',
			),
			27 => 
			array (
				'id' => 28,
				'name' => 'Appenzeller Sennenhund',
				'size' => 'M',
			),
			28 => 
			array (
				'id' => 29,
				'name' => 'Argentine Dogo',
				'size' => 'L',
			),
			29 => 
			array (
				'id' => 30,
				'name' => 'Ariege Pointer',
				'size' => 'L',
			),
			30 => 
			array (
				'id' => 31,
				'name' => 'Ariegeois',
				'size' => 'M',
			),
			31 => 
			array (
				'id' => 32,
				'name' => 'Australian Bulldog',
				'size' => 'M',
			),
			32 => 
			array (
				'id' => 33,
				'name' => 'Australian Cattle Dog',
				'size' => 'M',
			),
			33 => 
			array (
				'id' => 34,
				'name' => 'Australian Kelpie',
				'size' => 'M',
			),
			34 => 
			array (
				'id' => 35,
				'name' => 'Australian Shepherd',
				'size' => 'M',
			),
			35 => 
			array (
				'id' => 36,
				'name' => 'Australian Silky Terrier',
				'size' => 'S',
			),
			36 => 
			array (
				'id' => 37,
				'name' => 'Australian Stumpy Tail Cattle Dog',
				'size' => 'M',
			),
			37 => 
			array (
				'id' => 38,
				'name' => 'Australian Terrier',
				'size' => 'S',
			),
			38 => 
			array (
				'id' => 39,
				'name' => 'Austrian Black and Tan Hound',
				'size' => 'M',
			),
			39 => 
			array (
				'id' => 40,
				'name' => 'Austrian Pinscher',
				'size' => 'M',
			),
			40 => 
			array (
				'id' => 41,
				'name' => 'Azawakh',
				'size' => 'L',
			),
			41 => 
			array (
				'id' => 42,
				'name' => 'Barbet',
				'size' => 'M',
			),
			42 => 
			array (
				'id' => 43,
				'name' => 'Basenji',
				'size' => 'M',
			),
			43 => 
			array (
				'id' => 44,
				'name' => 'Basset Artesien Normand',
				'size' => 'S',
			),
			44 => 
			array (
				'id' => 45,
				'name' => 'Basset Bleu de Gascogne',
				'size' => 'S',
			),
			45 => 
			array (
				'id' => 46,
				'name' => 'Basset Fauve de Bretagne',
				'size' => 'S',
			),
			46 => 
			array (
				'id' => 47,
				'name' => 'Basset Hound',
				'size' => 'M',
			),
			47 => 
			array (
				'id' => 48,
				'name' => 'Bavarian Mountain Hound',
				'size' => 'M',
			),
			48 => 
			array (
				'id' => 49,
				'name' => 'Beagle',
				'size' => 'S',
			),
			49 => 
			array (
				'id' => 50,
				'name' => 'Beagle-Harrier',
				'size' => 'M',
			),
			50 => 
			array (
				'id' => 51,
				'name' => 'Beaglier',
				'size' => 'M',
			),
			51 => 
			array (
				'id' => 52,
				'name' => 'Bearded Collie',
				'size' => 'M',
			),
			52 => 
			array (
				'id' => 53,
				'name' => 'Beauceron',
				'size' => 'L',
			),
			53 => 
			array (
				'id' => 54,
				'name' => 'Bedlington Terrier',
				'size' => 'S',
			),
			54 => 
			array (
				'id' => 55,
				'name' => 'Belgian Shepherd Laekenois',
				'size' => 'M',
			),
			55 => 
			array (
				'id' => 56,
				'name' => 'Belgian Shepherd Malinois',
				'size' => 'M',
			),
			56 => 
			array (
				'id' => 57,
				'name' => 'Belgian Shepherd Tervuren',
				'size' => 'M',
			),
			57 => 
			array (
				'id' => 58,
				'name' => 'Bergamasco',
				'size' => 'M',
			),
			58 => 
			array (
				'id' => 59,
				'name' => 'Berger Picard',
				'size' => 'M',
			),
			59 => 
			array (
				'id' => 60,
				'name' => 'Bernese Mountain Dog',
				'size' => 'L',
			),
			60 => 
			array (
				'id' => 61,
				'name' => 'Bichon Frise',
				'size' => 'S',
			),
			61 => 
			array (
				'id' => 62,
				'name' => 'Black and Tan Coonhound',
				'size' => 'L',
			),
			62 => 
			array (
				'id' => 63,
				'name' => 'Black Norwegian Elkhound',
				'size' => 'S',
			),
			63 => 
			array (
				'id' => 64,
				'name' => 'Black Russian Terrier',
				'size' => 'L',
			),
			64 => 
			array (
				'id' => 65,
				'name' => 'Blackmouth Cur',
				'size' => 'M',
			),
			65 => 
			array (
				'id' => 66,
				'name' => 'Bloodhound',
				'size' => 'L',
			),
			66 => 
			array (
				'id' => 67,
				'name' => 'Blue Lacy',
				'size' => 'M',
			),
			67 => 
			array (
				'id' => 68,
				'name' => 'Blue Picardy Spaniel',
				'size' => 'L',
			),
			68 => 
			array (
				'id' => 69,
				'name' => 'Bluetick Coonhound',
				'size' => 'M',
			),
			69 => 
			array (
				'id' => 70,
				'name' => 'Boerboel',
				'size' => 'L',
			),
			70 => 
			array (
				'id' => 71,
				'name' => 'Bohemian Shepherd',
				'size' => 'M',
			),
			71 => 
			array (
				'id' => 72,
				'name' => 'Bolognese dog',
				'size' => 'S',
			),
			72 => 
			array (
				'id' => 73,
				'name' => 'Border Collie',
				'size' => 'M',
			),
			73 => 
			array (
				'id' => 74,
				'name' => 'Border Terrier',
				'size' => 'S',
			),
			74 => 
			array (
				'id' => 75,
				'name' => 'Borzoi',
				'size' => 'XL',
			),
			75 => 
			array (
				'id' => 76,
				'name' => 'Boston Terrier',
				'size' => 'S',
			),
			76 => 
			array (
				'id' => 77,
				'name' => 'Bouvier de Ardennes',
				'size' => 'M',
			),
			77 => 
			array (
				'id' => 78,
				'name' => 'Bouvier des Flanders',
				'size' => 'L',
			),
			78 => 
			array (
				'id' => 79,
				'name' => 'Boxer',
				'size' => 'M',
			),
			79 => 
			array (
				'id' => 80,
				'name' => 'Boykin Spaniel',
				'size' => 'M',
			),
			80 => 
			array (
				'id' => 81,
				'name' => 'Bracco Italiano',
				'size' => 'L',
			),
			81 => 
			array (
				'id' => 82,
				'name' => 'Braque du Bourbonnais',
				'size' => 'M',
			),
			82 => 
			array (
				'id' => 83,
				'name' => 'Brazilian Terrier',
				'size' => 'S',
			),
			83 => 
			array (
				'id' => 84,
				'name' => 'Briard',
				'size' => 'L',
			),
			84 => 
			array (
				'id' => 85,
				'name' => 'Briquet Griffon Vendeen',
				'size' => 'M',
			),
			85 => 
			array (
				'id' => 86,
				'name' => 'Brussels Griffon',
				'size' => 'S',
			),
			86 => 
			array (
				'id' => 87,
				'name' => 'Bukovina Sheepdog',
				'size' => 'L',
			),
			87 => 
			array (
				'id' => 88,
				'name' => 'Bulgarian Shepherd Dog',
				'size' => 'L',
			),
			88 => 
			array (
				'id' => 89,
				'name' => 'Bull Terrier',
				'size' => 'M',
			),
			89 => 
			array (
				'id' => 90,
				'name' => 'Bulldog',
				'size' => 'M',
			),
			90 => 
			array (
				'id' => 91,
				'name' => 'Bullmastiff',
				'size' => 'L',
			),
			91 => 
			array (
				'id' => 92,
				'name' => 'Cão da Serra de Aires',
				'size' => 'M',
			),
			92 => 
			array (
				'id' => 93,
				'name' => 'Cairn Terrier',
				'size' => 'S',
			),
			93 => 
			array (
				'id' => 94,
				'name' => 'Canaan Dog',
				'size' => 'M',
			),
			94 => 
			array (
				'id' => 95,
				'name' => 'Canadian Eskimo Dog',
				'size' => 'L',
			),
			95 => 
			array (
				'id' => 96,
				'name' => 'Cane Corso Italiano',
				'size' => 'L',
			),
			96 => 
			array (
				'id' => 97,
				'name' => 'Caravan Hound',
				'size' => 'L',
			),
			97 => 
			array (
				'id' => 98,
				'name' => 'Cardigan Welsh Corgi',
				'size' => 'S',
			),
			98 => 
			array (
				'id' => 99,
				'name' => 'Carolina Dog',
				'size' => 'M',
			),
			99 => 
			array (
				'id' => 100,
				'name' => 'Carpathian Sheepdog',
				'size' => 'L',
			),
			100 => 
			array (
				'id' => 101,
				'name' => 'Catahoula Bulldog',
				'size' => '',
			),
			101 => 
			array (
				'id' => 102,
				'name' => 'Catahoula Cur',
				'size' => 'M',
			),
			102 => 
			array (
				'id' => 103,
				'name' => 'Catahoula Leopard Dog',
				'size' => 'M',
			),
			103 => 
			array (
				'id' => 104,
				'name' => 'Catalan Sheepdog',
				'size' => 'M',
			),
			104 => 
			array (
				'id' => 105,
				'name' => 'Caucasian Ovtcharka',
				'size' => 'XL',
			),
			105 => 
			array (
				'id' => 106,
				'name' => 'Cavalier King Charles Spaniel',
				'size' => 'S',
			),
			106 => 
			array (
				'id' => 107,
				'name' => 'Central Asian Ovtcharka',
				'size' => 'L',
			),
			107 => 
			array (
				'id' => 108,
				'name' => 'Cesky Fousek',
				'size' => 'M',
			),
			108 => 
			array (
				'id' => 109,
				'name' => 'Cesky Terrier',
				'size' => 'S',
			),
			109 => 
			array (
				'id' => 110,
				'name' => 'Chart Polski',
				'size' => 'L',
			),
			110 => 
			array (
				'id' => 111,
				'name' => 'Chesapeake Bay Retriever',
				'size' => 'L',
			),
			111 => 
			array (
				'id' => 112,
				'name' => 'Chihuahua',
				'size' => 'S',
			),
			112 => 
			array (
				'id' => 113,
				'name' => 'Chinese Crested',
				'size' => 'S',
			),
			113 => 
			array (
				'id' => 114,
				'name' => 'Chow Chow',
				'size' => 'M',
			),
			114 => 
			array (
				'id' => 115,
				'name' => 'Cirneco Dell Etna',
				'size' => 'M',
			),
			115 => 
			array (
				'id' => 116,
				'name' => 'Clumber Spaniel',
				'size' => 'M',
			),
			116 => 
			array (
				'id' => 117,
				'name' => 'Cockapoo',
				'size' => 'S',
			),
			117 => 
			array (
				'id' => 118,
				'name' => 'Coton De Tulear',
				'size' => 'S',
			),
			118 => 
			array (
				'id' => 119,
				'name' => 'Croatian Sheepdog',
				'size' => 'M',
			),
			119 => 
			array (
				'id' => 120,
				'name' => 'Curly-Coated Retriever',
				'size' => 'L',
			),
			120 => 
			array (
				'id' => 121,
				'name' => 'Czechoslovakian Wolfdog',
				'size' => 'L',
			),
			121 => 
			array (
				'id' => 122,
				'name' => 'Dachshund',
				'size' => 'S',
			),
			122 => 
			array (
				'id' => 123,
				'name' => 'Dalmatian',
				'size' => 'L',
			),
			123 => 
			array (
				'id' => 124,
				'name' => 'Dandie Dinmont Terrier',
				'size' => 'S',
			),
			124 => 
			array (
				'id' => 125,
				'name' => 'Danish-Swedish Farmdog',
				'size' => 'M',
			),
			125 => 
			array (
				'id' => 126,
				'name' => 'Deutsche Bracke',
				'size' => 'M',
			),
			126 => 
			array (
				'id' => 127,
				'name' => 'Dingo',
				'size' => 'M',
			),
			127 => 
			array (
				'id' => 128,
				'name' => 'Doberman Pinscher',
				'size' => 'L',
			),
			128 => 
			array (
				'id' => 129,
				'name' => 'Dogue de Bordeaux',
				'size' => 'L',
			),
			129 => 
			array (
				'id' => 130,
				'name' => 'Drentse Patrijshond',
				'size' => 'M',
			),
			130 => 
			array (
				'id' => 131,
				'name' => 'Drever',
				'size' => 'S',
			),
			131 => 
			array (
				'id' => 132,
				'name' => 'Dunker',
				'size' => 'M',
			),
			132 => 
			array (
				'id' => 133,
				'name' => 'Dutch Shepherd Dog',
				'size' => 'L',
			),
			133 => 
			array (
				'id' => 134,
				'name' => 'Dutch Smoushond',
				'size' => 'S',
			),
			134 => 
			array (
				'id' => 135,
				'name' => 'East Siberian Laika',
				'size' => 'M',
			),
			135 => 
			array (
				'id' => 136,
				'name' => 'East-European Shepherd',
				'size' => 'L',
			),
			136 => 
			array (
				'id' => 137,
				'name' => 'English Coonhound',
				'size' => 'L',
			),
			137 => 
			array (
				'id' => 138,
				'name' => 'English Foxhound',
				'size' => 'M',
			),
			138 => 
			array (
				'id' => 139,
				'name' => 'English Mastiff',
				'size' => 'L',
			),
			139 => 
			array (
				'id' => 140,
				'name' => 'English Setter',
				'size' => 'L',
			),
			140 => 
			array (
				'id' => 141,
				'name' => 'English Shepherd',
				'size' => 'M',
			),
			141 => 
			array (
				'id' => 142,
				'name' => 'English Springer Spaniel',
				'size' => 'M',
			),
			142 => 
			array (
				'id' => 143,
				'name' => 'Entlebucher Mountain Dog',
				'size' => 'M',
			),
			143 => 
			array (
				'id' => 144,
				'name' => 'Eurasier',
				'size' => 'M',
			),
			144 => 
			array (
				'id' => 145,
				'name' => 'Field Spaniel',
				'size' => 'M',
			),
			145 => 
			array (
				'id' => 146,
				'name' => 'Fila Brasileiro',
				'size' => 'L',
			),
			146 => 
			array (
				'id' => 147,
				'name' => 'Finnish Hound',
				'size' => 'M',
			),
			147 => 
			array (
				'id' => 148,
				'name' => 'Finnish Lapphund',
				'size' => 'M',
			),
			148 => 
			array (
				'id' => 149,
				'name' => 'Finnish Spitz',
				'size' => 'M',
			),
			149 => 
			array (
				'id' => 150,
				'name' => 'Flat-Coated Retriever',
				'size' => 'L',
			),
			150 => 
			array (
				'id' => 151,
				'name' => 'Francais Blanc et Noir',
				'size' => 'L',
			),
			151 => 
			array (
				'id' => 152,
				'name' => 'French Brittany',
				'size' => 'M',
			),
			152 => 
			array (
				'id' => 153,
				'name' => 'French Bulldog',
				'size' => 'S',
			),
			153 => 
			array (
				'id' => 154,
				'name' => 'French Spaniel',
				'size' => 'M',
			),
			154 => 
			array (
				'id' => 155,
				'name' => 'German Longhaired Pointer',
				'size' => 'L',
			),
			155 => 
			array (
				'id' => 156,
				'name' => 'German Pinscher',
				'size' => 'M',
			),
			156 => 
			array (
				'id' => 157,
				'name' => 'German Shepherd Dog',
				'size' => 'L',
			),
			157 => 
			array (
				'id' => 158,
				'name' => 'German Shorthaired Pointer',
				'size' => 'L',
			),
			158 => 
			array (
				'id' => 159,
				'name' => 'German Wirehaired Pointer',
				'size' => 'M ',
			),
			159 => 
			array (
				'id' => 160,
				'name' => 'Giant Schnauzer',
				'size' => 'XL',
			),
			160 => 
			array (
				'id' => 161,
				'name' => 'Glen of Imaal Terrier',
				'size' => 'S',
			),
			161 => 
			array (
				'id' => 162,
				'name' => 'Golden Retriever',
				'size' => 'L',
			),
			162 => 
			array (
				'id' => 163,
				'name' => 'Goldendoodle',
				'size' => 'S',
			),
			163 => 
			array (
				'id' => 164,
				'name' => 'Gordon Setter',
				'size' => 'L',
			),
			164 => 
			array (
				'id' => 165,
				'name' => 'Grand Basset Griffon Vendeen',
				'size' => 'M',
			),
			165 => 
			array (
				'id' => 166,
				'name' => 'Great Dane',
				'size' => 'L',
			),
			166 => 
			array (
				'id' => 167,
				'name' => 'Great Pyrenees',
				'size' => 'XL',
			),
			167 => 
			array (
				'id' => 168,
				'name' => 'Greater Swiss Mountain Dog',
				'size' => 'L',
			),
			168 => 
			array (
				'id' => 169,
				'name' => 'Greenland Dog',
				'size' => 'L',
			),
			169 => 
			array (
				'id' => 170,
				'name' => 'Greyhound',
				'size' => 'XL',
			),
			170 => 
			array (
				'id' => 171,
				'name' => 'Griffon bleu de Gascogne',
				'size' => 'M',
			),
			171 => 
			array (
				'id' => 172,
				'name' => 'Groenendael',
				'size' => 'L',
			),
			172 => 
			array (
				'id' => 173,
				'name' => 'Hamilton Hound',
				'size' => 'M',
			),
			173 => 
			array (
				'id' => 174,
				'name' => 'Harrier dog',
				'size' => 'M',
			),
			174 => 
			array (
				'id' => 175,
				'name' => 'Havanese',
				'size' => 'S',
			),
			175 => 
			array (
				'id' => 176,
				'name' => 'Hokkaido Dog',
				'size' => 'M',
			),
			176 => 
			array (
				'id' => 177,
				'name' => 'Hovawart',
				'size' => 'M',
			),
			177 => 
			array (
				'id' => 178,
				'name' => 'Ibizan Hound',
				'size' => 'L',
			),
			178 => 
			array (
				'id' => 179,
				'name' => 'Icelandic Sheepdog',
				'size' => 'M',
			),
			179 => 
			array (
				'id' => 180,
				'name' => 'Irish Red and White Setter',
				'size' => 'L',
			),
			180 => 
			array (
				'id' => 181,
				'name' => 'Irish Setter',
				'size' => 'L',
			),
			181 => 
			array (
				'id' => 182,
				'name' => 'Irish Terrier',
				'size' => 'S',
			),
			182 => 
			array (
				'id' => 183,
				'name' => 'Irish Water Spaniel',
				'size' => 'M',
			),
			183 => 
			array (
				'id' => 184,
				'name' => 'Irish Wolfhound',
				'size' => 'XL',
			),
			184 => 
			array (
				'id' => 185,
				'name' => 'Italian Greyhound',
				'size' => 'S',
			),
			185 => 
			array (
				'id' => 186,
				'name' => 'Jack Russell Terrier',
				'size' => 'S',
			),
			186 => 
			array (
				'id' => 187,
				'name' => 'Jagdterrier',
				'size' => 'S',
			),
			187 => 
			array (
				'id' => 188,
			'name' => 'Jamthund (Swedish Elkhound)',
				'size' => 'M',
			),
			188 => 
			array (
				'id' => 189,
				'name' => 'Japanese Chin',
				'size' => 'S',
			),
			189 => 
			array (
				'id' => 190,
				'name' => 'Japanese Spitz',
				'size' => 'S',
			),
			190 => 
			array (
				'id' => 191,
				'name' => 'Japanese Terrier',
				'size' => 'S',
			),
			191 => 
			array (
				'id' => 192,
				'name' => 'Karelian Bear Dog',
				'size' => 'M',
			),
			192 => 
			array (
				'id' => 193,
				'name' => 'Keeshond',
				'size' => 'S',
			),
			193 => 
			array (
				'id' => 194,
				'name' => 'Kerry Blue Terrier',
				'size' => 'M',
			),
			194 => 
			array (
				'id' => 195,
				'name' => 'Kishu',
				'size' => 'M',
			),
			195 => 
			array (
				'id' => 196,
				'name' => 'Komondor',
				'size' => 'L',
			),
			196 => 
			array (
				'id' => 197,
				'name' => 'Kooikerhondje',
				'size' => 'S',
			),
			197 => 
			array (
				'id' => 198,
				'name' => 'Koolie',
				'size' => 'M',
			),
			198 => 
			array (
				'id' => 199,
				'name' => 'Korean Jindo Dog',
				'size' => 'M',
			),
			199 => 
			array (
				'id' => 200,
				'name' => 'Kromfohrlander',
				'size' => 'M',
			),
			200 => 
			array (
				'id' => 201,
				'name' => 'Kuvasz',
				'size' => 'XL',
			),
			201 => 
			array (
				'id' => 202,
				'name' => 'Labrador Retriever',
				'size' => 'M',
			),
			202 => 
			array (
				'id' => 203,
				'name' => 'Lagotto Romagnolo',
				'size' => 'M',
			),
			203 => 
			array (
				'id' => 204,
				'name' => 'Lakeland Terrier',
				'size' => 'S',
			),
			204 => 
			array (
				'id' => 205,
				'name' => 'Lancashire Heeler',
				'size' => 'S',
			),
			205 => 
			array (
				'id' => 206,
				'name' => 'Landseer',
				'size' => 'XL',
			),
			206 => 
			array (
				'id' => 207,
				'name' => 'Lapponian Herder',
				'size' => 'M',
			),
			207 => 
			array (
				'id' => 208,
				'name' => 'Large Munsterlander',
				'size' => 'L',
			),
			208 => 
			array (
				'id' => 209,
				'name' => 'Leonberger',
				'size' => 'XL',
			),
			209 => 
			array (
				'id' => 210,
				'name' => 'Lhasa Apso',
				'size' => 'S',
			),
			210 => 
			array (
				'id' => 211,
				'name' => 'Lowchen',
				'size' => 'S',
			),
			211 => 
			array (
				'id' => 212,
				'name' => 'Maltese Dog',
				'size' => 'S',
			),
			212 => 
			array (
				'id' => 213,
				'name' => 'Manchester Terrier',
				'size' => 'S',
			),
			213 => 
			array (
				'id' => 214,
				'name' => 'McNab',
				'size' => 'M',
			),
			214 => 
			array (
				'id' => 215,
				'name' => 'Miniature Bull Terrier',
				'size' => 'S',
			),
			215 => 
			array (
				'id' => 216,
				'name' => 'Miniature Pinscher',
				'size' => 'S',
			),
			216 => 
			array (
				'id' => 217,
				'name' => 'Miniature Schnauzer',
				'size' => 'S',
			),
			217 => 
			array (
				'id' => 218,
				'name' => 'Mudi',
				'size' => 'M',
			),
			218 => 
			array (
				'id' => 219,
				'name' => 'Neapolitan Mastiff',
				'size' => 'L',
			),
			219 => 
			array (
				'id' => 220,
				'name' => 'New Guinea Singing Dog',
				'size' => 'M',
			),
			220 => 
			array (
				'id' => 221,
				'name' => 'Newfoundland',
				'size' => 'XL',
			),
			221 => 
			array (
				'id' => 222,
				'name' => 'Norfolk Terrier',
				'size' => 'S',
			),
			222 => 
			array (
				'id' => 223,
				'name' => 'Norrbottenspets',
				'size' => 'M',
			),
			223 => 
			array (
				'id' => 224,
				'name' => 'Northern Inuit Dog',
				'size' => 'L',
			),
			224 => 
			array (
				'id' => 225,
				'name' => 'Norwegian Buhund',
				'size' => 'M',
			),
			225 => 
			array (
				'id' => 226,
				'name' => 'Norwegian Elkhound',
				'size' => 'M',
			),
			226 => 
			array (
				'id' => 227,
				'name' => 'Norwegian Lundehund',
				'size' => 'S',
			),
			227 => 
			array (
				'id' => 228,
				'name' => 'Norwich Terrier',
				'size' => 'S',
			),
			228 => 
			array (
				'id' => 229,
				'name' => 'Old English Sheepdog',
				'size' => 'L',
			),
			229 => 
			array (
				'id' => 230,
				'name' => 'Olde English Bulldogge',
				'size' => 'L',
			),
			230 => 
			array (
				'id' => 231,
				'name' => 'Otterhound',
				'size' => 'L',
			),
			231 => 
			array (
				'id' => 232,
				'name' => 'Pakistani Mastiff',
				'size' => 'XL',
			),
			232 => 
			array (
				'id' => 233,
				'name' => 'Papillon dog',
				'size' => 'S',
			),
			233 => 
			array (
				'id' => 234,
				'name' => 'Parson Russell Terrier',
				'size' => 'S',
			),
			234 => 
			array (
				'id' => 235,
				'name' => 'Patterdale Terrier',
				'size' => 'S',
			),
			235 => 
			array (
				'id' => 236,
				'name' => 'Pekingese',
				'size' => 'S',
			),
			236 => 
			array (
				'id' => 237,
				'name' => 'Pembroke Welsh Corgi',
				'size' => 'S',
			),
			237 => 
			array (
				'id' => 238,
				'name' => 'Perro de Presa Canario',
				'size' => 'L',
			),
			238 => 
			array (
				'id' => 239,
				'name' => 'Perro de Presa Mallorquin',
				'size' => 'M',
			),
			239 => 
			array (
				'id' => 240,
				'name' => 'Peruvian Inca Orchid',
				'size' => 'M',
			),
			240 => 
			array (
				'id' => 241,
				'name' => 'Petit Basset Griffon Vendeen',
				'size' => 'S',
			),
			241 => 
			array (
				'id' => 242,
				'name' => 'Pharaoh Hound',
				'size' => 'L',
			),
			242 => 
			array (
				'id' => 243,
				'name' => 'Picardy Spaniel',
				'size' => 'L',
			),
			243 => 
			array (
				'id' => 244,
				'name' => 'Plott Hound',
				'size' => 'M',
			),
			244 => 
			array (
				'id' => 245,
				'name' => 'Plummer Terrier',
				'size' => 'S',
			),
			245 => 
			array (
				'id' => 246,
				'name' => 'Polish Hunting Dog',
				'size' => 'M',
			),
			246 => 
			array (
				'id' => 247,
				'name' => 'Polish Lowland Sheepdog',
				'size' => 'M',
			),
			247 => 
			array (
				'id' => 248,
				'name' => 'Pomeranian',
				'size' => 'S',
			),
			248 => 
			array (
				'id' => 249,
				'name' => 'Pont-Audemer Spaniel',
				'size' => 'M',
			),
			249 => 
			array (
				'id' => 250,
				'name' => 'Poodle',
				'size' => 'S',
			),
			250 => 
			array (
				'id' => 251,
				'name' => 'Portuguese Podengo',
				'size' => 'M',
			),
			251 => 
			array (
				'id' => 252,
				'name' => 'Portuguese Pointer',
				'size' => 'M',
			),
			252 => 
			array (
				'id' => 253,
				'name' => 'Portuguese Water Dog',
				'size' => 'M',
			),
			253 => 
			array (
				'id' => 254,
				'name' => 'Prazsky Krysarik',
				'size' => 'M',
			),
			254 => 
			array (
				'id' => 255,
				'name' => 'Pudelpointer',
				'size' => 'L',
			),
			255 => 
			array (
				'id' => 256,
				'name' => 'Pug',
				'size' => 'S',
			),
			256 => 
			array (
				'id' => 257,
				'name' => 'Puli,Pulik',
				'size' => 'M',
			),
			257 => 
			array (
				'id' => 258,
				'name' => 'Pumi',
				'size' => 'M',
			),
			258 => 
			array (
				'id' => 259,
				'name' => 'Pyrenean Shepherd',
				'size' => 'M',
			),
			259 => 
			array (
				'id' => 260,
				'name' => 'Rafeiro do Alentejo',
				'size' => 'L',
			),
			260 => 
			array (
				'id' => 261,
				'name' => 'Rajapalyam dog',
				'size' => 'L',
			),
			261 => 
			array (
				'id' => 262,
				'name' => 'Rat Terrier',
				'size' => 'S',
			),
			262 => 
			array (
				'id' => 263,
				'name' => 'Redbone Coonhound',
				'size' => 'M',
			),
			263 => 
			array (
				'id' => 264,
				'name' => 'Rhodesian Ridgeback',
				'size' => 'L',
			),
			264 => 
			array (
				'id' => 265,
				'name' => 'Rottweiler',
				'size' => 'L',
			),
			265 => 
			array (
				'id' => 266,
				'name' => 'Rough Collie',
				'size' => 'M',
			),
			266 => 
			array (
				'id' => 267,
				'name' => 'Russian Spaniel',
				'size' => 'S',
			),
			267 => 
			array (
				'id' => 268,
				'name' => 'Russian Toy',
				'size' => 'S',
			),
			268 => 
			array (
				'id' => 269,
				'name' => 'Saarloos wolfdog',
				'size' => 'L',
			),
			269 => 
			array (
				'id' => 270,
				'name' => 'Saluki',
				'size' => 'L',
			),
			270 => 
			array (
				'id' => 271,
				'name' => 'Samoyed',
				'size' => 'M',
			),
			271 => 
			array (
				'id' => 272,
				'name' => 'Sapsali',
				'size' => 'M',
			),
			272 => 
			array (
				'id' => 273,
				'name' => 'Sarplaninac',
				'size' => 'M',
			),
			273 => 
			array (
				'id' => 274,
				'name' => 'Schapendoes',
				'size' => 'M',
			),
			274 => 
			array (
				'id' => 275,
				'name' => 'Schipperke',
				'size' => 'S',
			),
			275 => 
			array (
				'id' => 276,
				'name' => 'Scottish Deerhound',
				'size' => 'XL',
			),
			276 => 
			array (
				'id' => 277,
				'name' => 'Scottish Terrier',
				'size' => 'S',
			),
			277 => 
			array (
				'id' => 278,
				'name' => 'Sealyham Terrier',
				'size' => 'S',
			),
			278 => 
			array (
				'id' => 279,
				'name' => 'Seppala Siberian Sleddog',
				'size' => 'M',
			),
			279 => 
			array (
				'id' => 280,
				'name' => 'Serbian Hound',
				'size' => 'M',
			),
			280 => 
			array (
				'id' => 281,
				'name' => 'Shar-Pei',
				'size' => 'M',
			),
			281 => 
			array (
				'id' => 282,
				'name' => 'Shetland Sheepdog',
				'size' => 'M ',
			),
			282 => 
			array (
				'id' => 283,
				'name' => 'Shiba Inu',
				'size' => 'S',
			),
			283 => 
			array (
				'id' => 284,
				'name' => 'Shih Tzu',
				'size' => 'S',
			),
			284 => 
			array (
				'id' => 285,
				'name' => 'Shikoku dog',
				'size' => 'M',
			),
			285 => 
			array (
				'id' => 286,
				'name' => 'Shiloh Shepherd dog',
				'size' => 'M',
			),
			286 => 
			array (
				'id' => 287,
				'name' => 'Siberian Husky',
				'size' => 'M',
			),
			287 => 
			array (
				'id' => 288,
				'name' => 'Silken Windhound',
				'size' => 'M',
			),
			288 => 
			array (
				'id' => 289,
				'name' => 'Skye Terrier',
				'size' => 'S',
			),
			289 => 
			array (
				'id' => 290,
				'name' => 'Sloughi',
				'size' => 'L',
			),
			290 => 
			array (
				'id' => 291,
				'name' => 'Smaland Hound',
				'size' => 'M',
			),
			291 => 
			array (
				'id' => 292,
				'name' => 'Small Munsterlander',
				'size' => 'M',
			),
			292 => 
			array (
				'id' => 293,
				'name' => 'Smooth Collie',
				'size' => 'L',
			),
			293 => 
			array (
				'id' => 294,
				'name' => 'Smooth Fox Terrier',
				'size' => 'S',
			),
			294 => 
			array (
				'id' => 295,
				'name' => 'Soft-coated Wheaten Terrier',
				'size' => 'M',
			),
			295 => 
			array (
				'id' => 296,
				'name' => 'South Russian Ovcharka',
				'size' => 'L',
			),
			296 => 
			array (
				'id' => 297,
				'name' => 'Spanish Mastiff',
				'size' => 'XL',
			),
			297 => 
			array (
				'id' => 298,
				'name' => 'Spanish Water Dog',
				'size' => 'M',
			),
			298 => 
			array (
				'id' => 299,
				'name' => 'Spinone Italiano',
				'size' => 'L',
			),
			299 => 
			array (
				'id' => 300,
			'name' => 'St. Bernard(Saint Bernard)',
				'size' => 'XL',
			),
			300 => 
			array (
				'id' => 301,
				'name' => 'Staffordshire Bull Terrier',
				'size' => 'M',
			),
			301 => 
			array (
				'id' => 302,
				'name' => 'Standard Schnauzer',
				'size' => 'M',
			),
			302 => 
			array (
				'id' => 303,
				'name' => 'Sussex Spaniel',
				'size' => 'S',
			),
			303 => 
			array (
				'id' => 304,
				'name' => 'Swedish Lapphund',
				'size' => 'M',
			),
			304 => 
			array (
				'id' => 305,
				'name' => 'Swedish Vallhund',
				'size' => 'S',
			),
			305 => 
			array (
				'id' => 306,
				'name' => 'Tamaskan Dog',
				'size' => 'L',
			),
			306 => 
			array (
				'id' => 307,
				'name' => 'Thai Bangkaew Dog',
				'size' => 'M',
			),
			307 => 
			array (
				'id' => 308,
				'name' => 'Thai Ridgeback',
				'size' => 'M',
			),
			308 => 
			array (
				'id' => 309,
				'name' => 'Tibetan Mastiff',
				'size' => 'L',
			),
			309 => 
			array (
				'id' => 310,
				'name' => 'Tibetan Spaniel',
				'size' => 'S',
			),
			310 => 
			array (
				'id' => 311,
				'name' => 'Tibetan Terrier',
				'size' => 'M',
			),
			311 => 
			array (
				'id' => 312,
				'name' => 'Tolling Retriever',
				'size' => 'M',
			),
			312 => 
			array (
				'id' => 313,
				'name' => 'Tornjak',
				'size' => 'L',
			),
			313 => 
			array (
				'id' => 314,
				'name' => 'Tosa',
				'size' => 'L',
			),
			314 => 
			array (
				'id' => 315,
				'name' => 'Toy Bulldog',
				'size' => 'S',
			),
			315 => 
			array (
				'id' => 316,
				'name' => 'Toy Fox Terrier',
				'size' => 'S',
			),
			316 => 
			array (
				'id' => 317,
				'name' => 'Toy Manchester Terrier',
				'size' => 'S',
			),
			317 => 
			array (
				'id' => 318,
				'name' => 'Transylvanian Hound',
				'size' => 'M',
			),
			318 => 
			array (
				'id' => 319,
				'name' => 'Treeing Walker Coonhound',
				'size' => 'M',
			),
			319 => 
			array (
				'id' => 320,
				'name' => 'Vizsla',
				'size' => 'M',
			),
			320 => 
			array (
				'id' => 321,
				'name' => 'Volpino Italiano',
				'size' => 'S',
			),
			321 => 
			array (
				'id' => 322,
				'name' => 'Weimaraner',
				'size' => 'M',
			),
			322 => 
			array (
				'id' => 323,
				'name' => 'Welsh Springer Spaniel',
				'size' => 'M',
			),
			323 => 
			array (
				'id' => 324,
				'name' => 'Welsh Terrier',
				'size' => 'S',
			),
			324 => 
			array (
				'id' => 325,
				'name' => 'West Highland White Terrier',
				'size' => 'S',
			),
			325 => 
			array (
				'id' => 326,
				'name' => 'West Siberian Laika',
				'size' => 'L',
			),
			326 => 
			array (
				'id' => 327,
				'name' => 'Wetterhoun',
				'size' => 'M',
			),
			327 => 
			array (
				'id' => 328,
				'name' => 'Whippet',
				'size' => 'M',
			),
			328 => 
			array (
				'id' => 329,
				'name' => 'Wire Fox Terrier',
				'size' => 'S',
			),
			329 => 
			array (
				'id' => 330,
				'name' => 'Wirehaired Pointing Griffon',
				'size' => 'M',
			),
			330 => 
			array (
				'id' => 331,
				'name' => 'Xoloitzcuintle',
				'size' => 'S',
			),
			331 => 
			array (
				'id' => 332,
				'name' => 'Yorkshire Terrier',
				'size' => 'S',
			),
		));
	}

}
