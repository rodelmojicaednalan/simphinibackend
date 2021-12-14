<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PicklistsTreatmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('picklists_treatments')->truncate();
        DB::table('picklists_treatments')->insert(['name' => 'Bridges', 
                                                   'description' => 'A bridge is a fixed replacement for a missing tooth or teeth. It\'s made by taking an impression of the surrounding teeth, which will eventually support the bridge.

                                                   A bridge is usually created from precious metal and porcelain and will be fixed in your mouth (unlike dentures, which can be removed).', 
                                                   'status' => 'Active']);
        DB::table('picklists_treatments')->insert(['name' => 'Crowns', 
                                                   'description' => 'A crown is a type of cap that completely covers a real tooth. It\'s made from either metal, or porcelain and metal, and is fixed in your mouth.

                                                   Crowns can be fitted where a tooth has broken, decayed or been damaged, or just to make a tooth look better.
                                                   
                                                   To fit a crown, the old tooth will need to be drilled down so it\'s like a small peg the crown will be fixed on to.
                                                   
                                                   It can take some time for the lab to prepare a new crown, so you probably won\'t have the crown fitted on the same day.', 
                                                   'status' => 'Active']);
        DB::table('picklists_treatments')->insert(['name' => 'Fillings', 
                                                   'description' => 'Fillings are used to repair a hole in a tooth caused by decay. The most common type of filling is an amalgam, made from a mixture of metals including mercury, silver, tin, copper and zinc.

                                                   Your dentist will offer the most appropriate type of filling according to your clinical needs. This includes white fillings, if appropriate.', 
                                                   'status' => 'Active']);
        DB::table('picklists_treatments')->insert(['name' => 'Root canal treatment', 
                                                   'description' => 'Root canal treatment (also called endodontics) tackles infection at the centre of a tooth (the root canal system).

                                                   When the blood or nerve supply of the tooth has become infected, the infection will spread and the tooth may need to be taken out if root canal treatment isn\'t carried out.
                                                   
                                                   During treatment, all the infection is removed from inside the root canal system.
                                                   
                                                   The root canal is filled and the tooth is sealed with a filling or crown to stop it becoming infected again.
                                                   
                                                   Root canal treatment usually requires 2 or 3 visits to your dentist.', 
                                                   'status' => 'Active']);
        DB::table('picklists_treatments')->insert(['name' => 'Scale and polish', 
                                                   'description' => 'This is when your teeth are professionally cleaned by the hygienist. It involves carefully removing the deposits that build up on the teeth (tartar).', 
                                                   'status' => 'Active']);
        DB::table('picklists_treatments')->insert(['name' => 'Braces ', 
                                                   'description' => 'Braces (orthodontic treatment) straighten or move teeth to improve the appearance of the teeth and how they work.

                                                   Braces can be removable, so you can take them out and clean them, or fixed, so they\'re stuck to your teeth and you can\'t take them out.
                                                   
                                                   They can be made of metal, plastic or ceramic. Invisible braces are made of a clear plastic.
                                                   
                                                   Braces are available on the NHS for children and, occasionally, for adults, depending on the clinical need.', 
                                                   'status' => 'Active']);
        DB::table('picklists_treatments')->insert(['name' => 'Wisdom tooth removal', 
                                                   'description' => 'The wisdom teeth grow at the back of your gums and are the last teeth to come through, usually in your late teens or early twenties.

                                                   Most people have 4 wisdom teeth, 1 in each corner.
                                                   
                                                   Wisdom teeth can sometimes emerge at an angle or get stuck and only emerge partially. Wisdom teeth that grow through in this way are known as impacted.
                                                   
                                                   Impacted wisdom teeth can be removed on the NHS. Your dentist may perform the procedure, or may refer you to a dentist with a special interest or a hospital\'s oral and maxillofacial unit.
                                                   
                                                   You\'ll usually have to pay a charge for wisdom tooth removal. If you\'re referred to a hospital for NHS treatment, you won\'t have to pay a charge.
                                                   
                                                   Your dentist can also refer you for private wisdom teeth treatment if you wish.', 
                                                   'status' => 'Active']);
        DB::table('picklists_treatments')->insert(['name' => 'Dental implants', 
                                                   'description' => 'Implants are a fixed alternative to removable dentures. They may be the only option if the loss of teeth has caused the mouth to shrink so it can no longer support dentures. 

                                                   You can use implants to replace just a single tooth or several teeth.
                                                   
                                                   To fit an implant, titanium screws are drilled into the jaw bone to support a crown, bridge or denture.
                                                   
                                                   Replacement parts take time to prepare. This is to ensure that they fit your mouth and other teeth properly. This means they may not be available on your first visit to the dentist.
                                                   
                                                   Implants are usually only available privately and are expensive. They\'re sometimes available on the NHS for patients who can\'t wear dentures or whose face and teeth have been damaged, such as people who have had mouth cancer or an accident that\'s knocked a tooth out.', 
                                                   'status' => 'Active']);
        DB::table('picklists_treatments')->insert(['name' => 'Dentures or false teeth', 
                                                   'description' => 'More commonly known as false teeth, dentures are fitted in place of natural teeth.

                                                   A full set is used to replace all your teeth. A part set is used to replace 1 or more missing teeth.
                                                   
                                                   Dentures are custom-made using impressions (mouldings) from your gums. They\'re usually made from metal or plastic.
                                                   
                                                   They\'re removable so you can clean them, although part dentures can be brushed at the same time as your other teeth.
                                                   
                                                   A full set needs to be removed and soaked in a cleaning solution.
                                                   
                                                   Dentures are important if you lose your natural teeth, as losing your teeth makes it difficult to chew your food, which will adversely affect your diet and may cause your facial muscles to sag.', 
                                                   'status' => 'Active']);
        DB::table('picklists_treatments')->insert(['name' => 'Broken or knocked out tooth', 
                                                   'description' => 'It\'s common to break, chip or knock out a tooth.

                                                   If the tooth is just chipped, make a non-emergency dental appointment to have it smoothed down and filled or have a crown.
                                                   
                                                   If the tooth has been knocked out or is badly broken, see a dentist immediately. Your dentist may fit a denture or bridge.
                                                   
                                                   If you need an implant, you\'ll be referred to a dental hospital.
                                                   
                                                   Treatment of whatever type can be provided by an NHS dentist and the cost covered on the NHS.', 
                                                   'status' => 'Active']);
        DB::table('picklists_treatments')->insert(['name' => 'Teeth whitening', 
                                                   'description' => 'Teeth whitening involves bleaching your teeth to make them a lighter colour.

                                                   Teeth whitening can\'t make your teeth brilliant white, but it can lighten the existing colour by several shades.
                                                   
                                                   Standard teeth whitening involves several visits to the dentist, plus sessions at home wearing a mouthguard containing bleaching gel.
                                                   
                                                   The whole process takes a couple of months.
                                                   
                                                   A newer procedure called laser whitening or power whitening is done at the dentist\'s surgery and takes about an hour. 
                                                   
                                                   Teeth whitening is cosmetic and therefore generally only available privately.', 
                                                   'status' => 'Active']);
        DB::table('picklists_treatments')->insert(['name' => 'Dental veneers', 
                                                   'description' => 'eneers are new facings for teeth that disguise a discoloured (rather than a damaged) tooth.

                                                   To fit a veneer, the front of the tooth is drilled away a little.
                                                   
                                                   An impression is taken, and a thin layer of porcelain is fitted over the front of the tooth (similar to how a false fingernail is applied).
                                                   
                                                   Veneers are generally only available privately, unless you can show a clinical need for them.', 
                                                   'status' => 'Active']);
    }
}
