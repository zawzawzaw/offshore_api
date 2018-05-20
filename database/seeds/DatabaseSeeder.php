<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call(UserTableSeeder::class);                
        $this->call(CountrySeeder::class);
        $this->call(CompanyTypeTableSeeder::class);
        $this->call(KeypersonnelSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(infoServiceSeeder::class);
        $this->call(CompanyTableSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        DB::table('users')->insert([
		    [
	        	'name' => 'admin',
	        	'email' => 'zaw@manic.com.sg',
	        	'password' => Hash::make( 'p@ssword' )        	
        	]
		]);        
    }
}

class CompanyTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('company_types')->delete();

        DB::table('company_types')->insert([
            [
                'name' => 'Cyprus limited liability company',             
                'price' => '2000',             
                'price_eu' => '1900',             
                'rules' => ''
            ],
            [
                'name' => 'Belize international business company',             
                'price' => '3000',             
                'price_eu' => '2900',             
                'rules' => ''
            ],
            [
                'name' => 'Test',             
                'price' => '1000',             
                'price_eu' => '900',             
                'rules' => ''
            ]
        ]);        
    }
}

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->delete();

        DB::table('companies')->insert([
            [
                'name' => 'Cyprus company a',
                'incorporation_date' => \Carbon\Carbon::createFromDate(2015,07,22)->toDateTimeString(),
                'price' => '1000',         
                'price_eu' => '900',         
                'shelf' => true,       
                'company_type_id' => 1     
            ],
            [
                'name' => 'Cyprus company b',
                'incorporation_date' => \Carbon\Carbon::createFromDate(2014,07,22)->toDateTimeString(),
                'price' => '1100', 
                'price_eu' => '1000', 
                'shelf' => true,
                'company_type_id' => 1
            ],
            [
                'name' => 'Belize Services Ltd',
                'incorporation_date' => \Carbon\Carbon::createFromDate(2013,07,22)->toDateTimeString(),
                'price' => '1200', 
                'price_eu' => '1100', 
                'shelf' => true,
                'company_type_id' => 2
            ],
            [
                'name' => 'Nat\'s Company Ltd',
                'incorporation_date' => \Carbon\Carbon::createFromDate(2012,07,22)->toDateTimeString(),
                'price' => '1300', 
                'price_eu' => '1200', 
                'shelf' => true,
                'company_type_id' => 1
            ]
        ]);        
    }
}

class KeypersonnelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('directors')->delete();

        DB::table('directors')->insert([
            [
                'name_rules' => 'At least one director is required, who may be either a natural person or another company. The directors may be resident anywhere in the world. If the company will wish to qualify for benefits under the network of double tax treates which Cyprus has in place with other countries, then it will be necessary for the majority of directors to be resident in Cyprus. It is possible for a single person to be a sole director and shareholder.  Professional directors may be appointed if confidentiality is required.  Please tick the box below if you would like Offshore Company Solutions to provide professional directors.',                
                'price' => '1000',         
                'price_eu' => '900',                
                'company_type_id' => 1
            ],
            [
                'name_rules' => 'At least one director is required, who may be either a natural person or another company. The directors may be resident anywhere in the world. If the company will wish to qualify for benefits under the network of double tax treates which Cyprus has in place with other countries, then it will be necessary for the majority of directors to be resident in Cyprus. It is possible for a single person to be a sole director and shareholder.  Professional directors may be appointed if confidentiality is required.  Please tick the box below if you would like Offshore Company Solutions to provide professional directors.',                
                'price' => '1000',         
                'price_eu' => '900',                
                'company_type_id' => 2
            ],
            [
                'name_rules' => 'At least one director is required, who may be either a natural person or another company. The directors may be resident anywhere in the world. If the company will wish to qualify for benefits under the network of double tax treates which Cyprus has in place with other countries, then it will be necessary for the majority of directors to be resident in Cyprus. It is possible for a single person to be a sole director and shareholder.  Professional directors may be appointed if confidentiality is required.  Please tick the box below if you would like Offshore Company Solutions to provide professional directors.',                
                'price' => '1000',         
                'price_eu' => '900',                
                'company_type_id' => 3
            ]
        ]);    

        DB::table('shareholders')->delete();

        DB::table('shareholders')->insert([
            [
                'name_rules' => 'At least one shareholder is required, to whom  a minimum of one share must be issued. Shareholders may be either natural persons or other corporate entities. Should confidentiality be required, the shares may be held via nominee shareholders. Please tick the box below if you would like Offshore Company Solutions to provide professional shareholders. Bearer shares are not allowed.',                
                'price' => '900',         
                'price_eu' => '800',                
                'company_type_id' => 1
            ],
            [
                'name_rules' => 'At least one shareholder is required, to whom  a minimum of one share must be issued. Shareholders may be either natural persons or other corporate entities. Should confidentiality be required, the shares may be held via nominee shareholders. Please tick the box below if you would like Offshore Company Solutions to provide professional shareholders. Bearer shares are not allowed.',                
                'price' => '900',         
                'price_eu' => '800',                
                'company_type_id' => 2
            ],
            [
                'name_rules' => 'At least one shareholder is required, to whom  a minimum of one share must be issued. Shareholders may be either natural persons or other corporate entities. Should confidentiality be required, the shares may be held via nominee shareholders. Please tick the box below if you would like Offshore Company Solutions to provide professional shareholders. Bearer shares are not allowed.',                
                'price' => '900',         
                'price_eu' => '800',                
                'company_type_id' => 3
            ]
        ]);    

        DB::table('secretaries')->delete();

        DB::table('secretaries')->insert([
            [
                'name_rules' => 'A company secretary must be appointed, who may be a natural person or company, resident in any country but preferably in Cyprus. The same person may act as both company secretary and director or company secretary and shareholder. It is possible for the same person to act as shareholder, director and secretary provided there is at least one other shareholder or director. secretary.Please tick the box below if you would like Offshore Company Solutions to provide a company secretary.',                
                'price' => '800',         
                'price_eu' => '700',                
                'company_type_id' => 1
            ],
            [
                'name_rules' => 'A company secretary must be appointed, who may be a natural person or company, resident in any country but preferably in Cyprus. The same person may act as both company secretary and director or company secretary and shareholder. It is possible for the same person to act as shareholder, director and secretary provided there is at least one other shareholder or director. secretary.Please tick the box below if you would like Offshore Company Solutions to provide a company secretary.',                
                'price' => '800',         
                'price_eu' => '700',                
                'company_type_id' => 2
            ],
            [
                'name_rules' => 'A company secretary must be appointed, who may be a natural person or company, resident in any country but preferably in Cyprus. The same person may act as both company secretary and director or company secretary and shareholder. It is possible for the same person to act as shareholder, director and secretary provided there is at least one other shareholder or director. secretary.Please tick the box below if you would like Offshore Company Solutions to provide a company secretary.',                
                'price' => '800',         
                'price_eu' => '700',                
                'company_type_id' => 3
            ]
        ]);        
    }
}


class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')->delete();

        DB::table('services')->insert([
            [
                'name' => 'Bank accounts',                
                'company_type_id' => '1'                
            ],
            [
                'name' => 'Credit/debit cards',                
                'company_type_id' => '1'
            ],
            [
                'name' => 'Registered office annual fee (compulsory)',                
                'company_type_id' => '1'
            ],
            [
                'name' => 'Bank accounts',                
                'company_type_id' => '2'                
            ],
            [
                'name' => 'Credit/debit cards',                
                'company_type_id' => '2'
            ],
            [
                'name' => 'Registered office annual fee (compulsory)',                
                'company_type_id' => '2'
            ],
            [
                'name' => 'Bank accounts',                
                'company_type_id' => '3'                
            ],
            [
                'name' => 'Credit/debit cards',                
                'company_type_id' => '3'
            ],
            [
                'name' => 'Registered office annual fee (compulsory)',                
                'company_type_id' => '3'
            ]
        ]);

        DB::table('service_country')->delete();

        DB::table('service_country')->insert([
            [
                'service_id' => '1',                
                'country_id' => '229',                
                'price' => '1000',                
                'price_eu' => '900'
            ],
            [
                'service_id' => '1',                
                'country_id' => '230',                
                'price' => '1200',                
                'price_eu' => '1100'
            ],
            [
                'service_id' => '1',                
                'country_id' => '38',                
                'price' => '1400',                
                'price_eu' => '1300'
            ],
            [
                'service_id' => '2',                
                'country_id' => '229',                
                'price' => '500',                
                'price_eu' => '400'
            ],
            [
                'service_id' => '2',                
                'country_id' => '230',                
                'price' => '600',                
                'price_eu' => '500'
            ],
            [
                'service_id' => '3',                
                'country_id' => '1',                
                'price' => '500',                
                'price_eu' => '400'
            ],
            [
                'service_id' => '4',                
                'country_id' => '13',                
                'price' => '1000',                
                'price_eu' => '900'
            ],
            [
                'service_id' => '4',                
                'country_id' => '158',                
                'price' => '1200',                
                'price_eu' => '1100'
            ],
            [
                'service_id' => '5',                
                'country_id' => '13',                
                'price' => '500',                
                'price_eu' => '400'
            ],
            [
                'service_id' => '5',                
                'country_id' => '158',                
                'price' => '600',                
                'price_eu' => '500'
            ],
            [
                'service_id' => '6',                
                'country_id' => '1',                
                'price' => '500',                
                'price_eu' => '400'
            ],
            [
                'service_id' => '7',                
                'country_id' => '13',                
                'price' => '1000',                
                'price_eu' => '900'
            ],
            [
                'service_id' => '7',                
                'country_id' => '158',                
                'price' => '1200',                
                'price_eu' => '1100'
            ],
            [
                'service_id' => '8',                
                'country_id' => '13',                
                'price' => '500',                
                'price_eu' => '400'
            ],
            [
                'service_id' => '8',                
                'country_id' => '158',                
                'price' => '600',                
                'price_eu' => '500'
            ],
            [
                'service_id' => '9',                
                'country_id' => '1',                
                'price' => '500',                
                'price_eu' => '400'
            ]
        ]);                
    }
}

class infoServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('information_services')->delete();

        DB::table('information_services')->insert([
            [
                'name' => 'Local telephone number',                
                'company_type_id' => '1'                
            ],
            [
                'name' => 'Mailing address and forwarding',                
                'company_type_id' => '1'
            ],
            [
                'name' => 'Setting up a physical office presence',                
                'company_type_id' => '1'                
            ],
            [
                'name' => 'Establishing a merchant account',                
                'company_type_id' => '1'
            ],
            [
                'name' => 'Purchasing real estate',                
                'company_type_id' => '1'                
            ],
            [
                'name' => 'Economic citizenship possibilities',                
                'company_type_id' => '1'
            ],
            [
                'name' => 'Local telephone number',                
                'company_type_id' => '2'                
            ],
            [
                'name' => 'Mailing address and forwarding',                
                'company_type_id' => '2'
            ],
            [
                'name' => 'Setting up a physical office presence',                
                'company_type_id' => '2'                
            ],
            [
                'name' => 'Establishing a merchant account',                
                'company_type_id' => '2'
            ],
            [
                'name' => 'Purchasing real estate',                
                'company_type_id' => '2'                
            ],
            [
                'name' => 'Economic citizenship possibilities',                
                'company_type_id' => '2'
            ],
            [
                'name' => 'Info 1',                
                'company_type_id' => '3'
            ]
        ]);                
    }
}

/**
* 
*/
class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->delete();

        DB::table('countries')->insert([
            ['name' => 'Afghanistan'],
            ['name' => 'Albania'],
            ['name' => 'Algeria'],
            ['name' => 'American Samoa'],
            ['name' => 'Andorra'],
            ['name' => 'Angola'],
            ['name' => 'Anguilla'],
            ['name' => 'Antarctica'],
            ['name' => 'Antigua and Barbuda'],
            ['name' => 'Argentina'],
            ['name' => 'Armenia'],
            ['name' => 'Aruba'],
            ['name' => 'Australia'],
            ['name' => 'Austria'],
            ['name' => 'Azerbaijan'],
            ['name' => 'Bahamas'],
            ['name' => 'Bahrain'],
            ['name' => 'Bangladesh'],
            ['name' => 'Barbados'],
            ['name' => 'Belarus'],
            ['name' => 'Belgium'],
            ['name' => 'Belize'],
            ['name' => 'Benin'],
            ['name' => 'Bermuda'],
            ['name' => 'Bhutan'],
            ['name' => 'Bolivia'],
            ['name' => 'Bosnia and Herzegovina'],
            ['name' => 'Botswana'],
            ['name' => 'Bouvet Island'],
            ['name' => 'Brazil'],
            ['name' => 'British Indian Ocean Territory'],
            ['name' => 'Brunei Darussalam'],
            ['name' => 'Bulgaria'],
            ['name' => 'Burkina Faso'],
            ['name' => 'Burundi'],
            ['name' => 'Cambodia'],
            ['name' => 'Cameroon'],
            ['name' => 'Canada'],
            ['name' => 'Cape Verde'],
            ['name' => 'Cayman Islands'],
            ['name' => 'Central African Republic'],
            ['name' => 'Chad'],
            ['name' => 'Chile'],
            ['name' => 'China'],
            ['name' => 'Christmas Island'],
            ['name' => 'Cocos (Keeling) Islands'],
            ['name' => 'Colombia'],
            ['name' => 'Comoros'],
            ['name' => 'Congo'],
            ['name' => 'Cook Islands'],
            ['name' => 'Costa Rica'],
            ['name' => 'Croatia (Hrvatska)'],
            ['name' => 'Cuba'],
            ['name' => 'Cyprus'],
            ['name' => 'Czech Republic'],
            ['name' => 'Denmark'],
            ['name' => 'Djibouti'],
            ['name' => 'Dominica'],
            ['name' => 'Dominican Republic'],
            ['name' => 'East Timor'],
            ['name' => 'Ecuador'],
            ['name' => 'Egypt'],
            ['name' => 'El Salvador'],
            ['name' => 'Equatorial Guinea'],
            ['name' => 'Eritrea'],
            ['name' => 'Estonia'],
            ['name' => 'Ethiopia'],
            ['name' => 'Falkland Islands (Malvinas)'],
            ['name' => 'Faroe Islands'],
            ['name' => 'Fiji'],
            ['name' => 'Finland'],
            ['name' => 'France'],
            ['name' => 'France, Metropolitan'],
            ['name' => 'French Guiana'],
            ['name' => 'French Polynesia'],
            ['name' => 'French Southern Territories'],
            ['name' => 'Gabon'],
            ['name' => 'Gambia'],
            ['name' => 'Georgia'],
            ['name' => 'Germany'],
            ['name' => 'Ghana'],
            ['name' => 'Gibraltar'],
            ['name' => 'Guernsey'],
            ['name' => 'Greece'],
            ['name' => 'Greenland'],
            ['name' => 'Grenada'],
            ['name' => 'Guadeloupe'],
            ['name' => 'Guam'],
            ['name' => 'Guatemala'],
            ['name' => 'Guinea'],
            ['name' => 'Guinea-Bissau'],
            ['name' => 'Guyana'],
            ['name' => 'Haiti'],
            ['name' => 'Heard and Mc Donald Islands'],
            ['name' => 'Honduras'],
            ['name' => 'Hong Kong'],
            ['name' => 'Hungary'],
            ['name' => 'Iceland'],
            ['name' => 'India'],
            ['name' => 'Isle of Man'],
            ['name' => 'Indonesia'],
            ['name' => 'Iran (Islamic Republic of)'],
            ['name' => 'Iraq'],
            ['name' => 'Ireland'],
            ['name' => 'Israel'],
            ['name' => 'Italy'],
            ['name' => 'Ivory Coast'],
            ['name' => 'Jersey'],
            ['name' => 'Jamaica'],
            ['name' => 'Japan'],
            ['name' => 'Jordan'],
            ['name' => 'Kazakhstan'],
            ['name' => 'Kenya'],
            ['name' => 'Kiribati'],
            ['name' => 'Korea, Democratic People`s Republic of'],
            ['name' => 'Korea, Republic of'],
            ['name' => 'Kosovo'],
            ['name' => 'Kuwait'],
            ['name' => 'Kyrgyzstan'],
            ['name' => 'Lao People`s Democratic Republic'],
            ['name' => 'Latvia'],
            ['name' => 'Lebanon'],
            ['name' => 'Lesotho'],
            ['name' => 'Liberia'],
            ['name' => 'Libyan Arab Jamahiriya'],
            ['name' => 'Liechtenstein'],
            ['name' => 'Lithuania'],
            ['name' => 'Luxembourg'],
            ['name' => 'Macau'],
            ['name' => 'Macedonia'],
            ['name' => 'Madagascar'],
            ['name' => 'Malawi'],
            ['name' => 'Malaysia'],
            ['name' => 'Maldives'],
            ['name' => 'Mali'],
            ['name' => 'Malta'],
            ['name' => 'Marshall Islands'],
            ['name' => 'Martinique'],
            ['name' => 'Mauritania'],
            ['name' => 'Mauritius'],
            ['name' => 'Mayotte'],
            ['name' => 'Mexico'],
            ['name' => 'Micronesia, Federated States of'],
            ['name' => 'Moldova, Republic of'],
            ['name' => 'Monaco'],
            ['name' => 'Mongolia'],
            ['name' => 'Montenegro'],
            ['name' => 'Montserrat'],
            ['name' => 'Morocco'],
            ['name' => 'Mozambique'],
            ['name' => 'Myanmar'],
            ['name' => 'Namibia'],
            ['name' => 'Nauru'],
            ['name' => 'Nepal'],
            ['name' => 'Netherlands'],
            ['name' => 'Netherlands Antilles'],
            ['name' => 'New Caledonia'],
            ['name' => 'New Zealand'],
            ['name' => 'Nicaragua'],
            ['name' => 'Niger'],
            ['name' => 'Nigeria'],
            ['name' => 'Niue'],
            ['name' => 'Norfolk Island'],
            ['name' => 'Northern Mariana Islands'],
            ['name' => 'Norway'],
            ['name' => 'Oman'],
            ['name' => 'Pakistan'],
            ['name' => 'Palau'],
            ['name' => 'Palestine'],
            ['name' => 'Panama'],
            ['name' => 'Papua New Guinea'],
            ['name' => 'Paraguay'],
            ['name' => 'Peru'],
            ['name' => 'Philippines'],
            ['name' => 'Pitcairn'],
            ['name' => 'Poland'],
            ['name' => 'Portugal'],
            ['name' => 'Puerto Rico'],
            ['name' => 'Qatar'],
            ['name' => 'Reunion'],
            ['name' => 'Romania'],
            ['name' => 'Russian Federation'],
            ['name' => 'Rwanda'],
            ['name' => 'Saint Kitts and Nevis'],
            ['name' => 'Saint Lucia'],
            ['name' => 'Saint Vincent and the Grenadines'],
            ['name' => 'Samoa'],
            ['name' => 'San Marino'],
            ['name' => 'Sao Tome and Principe'],
            ['name' => 'Saudi Arabia'],
            ['name' => 'Senegal'],
            ['name' => 'Serbia'],
            ['name' => 'Seychelles'],
            ['name' => 'Sierra Leone'],
            ['name' => 'Singapore'],
            ['name' => 'Slovakia'],
            ['name' => 'Slovenia'],
            ['name' => 'Solomon Islands'],
            ['name' => 'Somalia'],
            ['name' => 'South Africa'],
            ['name' => 'South Georgia South Sandwich Islands'],
            ['name' => 'Spain'],
            ['name' => 'Sri Lanka'],
            ['name' => 'St. Helena'],
            ['name' => 'St. Pierre and Miquelon'],
            ['name' => 'Sudan'],
            ['name' => 'Suriname'],
            ['name' => 'Svalbard and Jan Mayen Islands'],
            ['name' => 'Swaziland'],
            ['name' => 'Sweden'],
            ['name' => 'Switzerland'],
            ['name' => 'Syrian Arab Republic'],
            ['name' => 'Taiwan'],
            ['name' => 'Tajikistan'],
            ['name' => 'Tanzania, United Republic of'],
            ['name' => 'Thailand'],
            ['name' => 'Togo'],
            ['name' => 'Tokelau'],
            ['name' => 'Tonga'],
            ['name' => 'Trinidad and Tobago'],
            ['name' => 'Tunisia'],
            ['name' => 'Turkey'],
            ['name' => 'Turkmenistan'],
            ['name' => 'Turks and Caicos Islands'],
            ['name' => 'Tuvalu'],
            ['name' => 'Uganda'],
            ['name' => 'Ukraine'],
            ['name' => 'United Arab Emirates'],
            ['name' => 'United Kingdom'],
            ['name' => 'United States'],
            ['name' => 'United States minor outlying islands'],
            ['name' => 'Uruguay'],
            ['name' => 'Uzbekistan'],
            ['name' => 'Vanuatu'],
            ['name' => 'Vatican City State'],
            ['name' => 'Venezuela'],
            ['name' => 'Vietnam'],
            ['name' => 'Virgin Islands (British)'],
            ['name' => 'Virgin Islands (U.S.)'],
            ['name' => 'Wallis and Futuna Islands'],
            ['name' => 'Western Sahara'],
            ['name' => 'Yemen'],
            ['name' => 'Yugoslavia'],
            ['name' => 'Zaire'],
            ['name' => 'Zambia'],
            ['name' => 'Zimbabwe']
        ]);
    }
}