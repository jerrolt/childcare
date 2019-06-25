<?php

use Illuminate\Database\Seeder;
use App\Carrier;

class CarriersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //		
		$carriers = [
			'3 River Wireless|sms.3rivers.net',			
			'ACS Wireless|paging.acswireless.com',
			'Alltel|message.alltel.com',
			'AT&T|txt.att.net',						
			'Bell Mobility|txt.bellmobility.ca',
			'Bell Mobility (Canada)|txt.bell.ca',	
			'Blue Sky Frog|blueskyfrog.com',
			'Bluegrass Cellular|sms.bluecell.com',
			'Boost Mobile|myboostmobile.com',
			'BPL Mobile|bplmobile.com',
			'Carolina West Wireless|cwwsms.com',			
			'Cellular One|mobile.celloneusa.com',
			'Cellular South|csouth1.com',
			'Centennial Wireless|cwemail.com',
			'CenturyTel|messaging.centurytel.net',
			'Cingular (Now AT&T)|txt.att.net',
			'Clearnet|msg.clearnet.com',
			'Comcast|comcastpcs.textmsg.com',
			'Corr Wireless Communications|corrwireless.net',
			'Dobson|mobile.dobson.net',
			'Edge Wireless|sms.edgewireless.com',	
			'Fido|fido.ca',
			'Golden Telecom|sms.goldentele.com',
			'Helio|messaging.sprintpcs.com',
			'Houston Cellular|text.houstoncellular.net',
			'Idea Cellular|ideacellular.net',
			'Illinois Valley Cellular|ivctext.com',
			'Inland Cellular Telephone|inlandlink.com',
			'MCI|pagemci.com',
			'Metro PCS|mymetropcs.com',
			'Metrocall|page.metrocall.com',				
			'Metrocall 2-way|my2way.com',
			'Microcell|fido.ca',
			'Midwest Wireless|clearlydigital.com',
			'Mobilcomm|mobilecomm.net',
			'MTS|text.mtsmobility.com',						
			'Nextel|messaging.nextel.com',
			'OnlineBeep|onlinebeep.net',
			'PCS One|pcsone.net',					
			'Presidents Choice|txt.bell.ca',
			'Public Service Cellular|sms.pscel.com',
			'Qwest|qwestmp.com',
			'Rogers AT&T Wireless|pcs.rogers.com',
			'Rogers Canada|pcs.rogers.com',		
			'Solo Mobile|txt.bell.ca',
			'Southwestern Bell|email.swbw.com',
			'Sprint|messaging.sprintpcs.com',
			'Sumcom|tms.suncom.com',
			'Surewest Communicaitons|mobile.surewest.com',
			'Telus|msg.telus.com',			
			'T-Mobile|tmomail.net',
			'Tracfone|txt.att.net',
			'Triton|tms.suncom.com',
			'Unicel|utext.com',					
			'US Cellular|email.uscc.net',
			'US West|uswestdatamail.com',
			'Verizon|vtext.com',
			'Virgin Mobile|vmobl.com',
			'Virgin Mobile Canada|vmobile.ca',
			'West Central Wireless|sms.wcc.net',
			'Western Wireless|cellularonewest.com'			
		];
								
		foreach($carriers as $k=>$carrier)
		{
			list($name, $domain) = explode("|", $carrier);
			$c = new Carrier();
			$c->name = trim($name);
			$c->domain = trim($domain);
			$c->save();		
		}
				
		
        /*
        $c = new Carrier();
		$c->name = '3 River Wireless';		
		$c->domain = 'sms.3rivers.net';
		$c->save();
		//
        $c = new Carrier();
		$c->name = 'ACS Wireless';		
		$c->domain = 'paging.acswireless.com';
		$c->save();
		
		$c = new Carrier();
		$c->name = 'Alltel';
		$c->domain = 'message.alltel.com';
		$c->save();
		
		$c = new Carrier();
		$c->name = 'AT&T';
		$c->domain = 'txt.att.net';
		$c->save();
		
		//$c = new Carrier();
		//'Bell Canada';
		//'txt.bellmobility.ca';
		//$c->save();
		
		$c = new Carrier();
		$c->name = 'Blue Sky Frog';
		$c->domain = 'blueskyfrog.com';
		$c->save();
		
		$c = new Carrier();	
		$c->name = 'Bluegrass Cellular';
		$c->domain = 'sms.bluecell.com';
		$c->save();
		
		$c = new Carrier();
		$c->name = 'Boost Mobile';
		$c->domain = 'myboostmobile.com';
		$c->save();

		$c = new Carrier();
		$c->name = 'BPL Mobile';
		$c->domain = 'bplmobile.com';
		$c->save();

		$c = new Carrier();
		$c->name = '';
		$c->domain = '';
		$c->save();
		
		$c = new Carrier();
		$c->name = '';
		$c->domain = '';
		$c->save();
		
		$c = new Carrier();
		$c->name = '';
		$c->domain = '';
		$c->save();
		
		$c->name = '';
		$c->domain = '';
		$c->save();
		
		$c->name = '';
		$c->domain = '';
		
		$c->name = '';
		$c->domain = '';
		
		$c->name = '';
		$c->domain = '';
		
		$c->name = '';
		$c->domain = '';
		
		$c->name = '';
		$c->domain = '';
		$c->save();
		
		$c->name = '';
		$c->domain = '';
		
		$c->name = '';
		$c->domain = '';
				
		$c->name = '';
		$c->domain = '';
				
		$c->name = '';
		$c->domain = '';
				
		$c->name = '';
		$c->domain = '';
				
		$c->name = '';
		$c->domain = '';
				
		$c->name = '';
		$c->domain = '';
				
		$c->name = '';
		$c->domain = '';
				
		$c->name = '';
		$c->domain = '';
				
		$c->name = '';
		$c->domain = '';
				
		$c->name = '';
		$c->domain = '';
				
		$c->name = '';
		$c->domain = '';
				
		$c->name = '';
		$c->domain = '';
				
		$c->name = '';
		$c->domain = '';
				
		$c->name = '';
		$c->domain = '';
		*/		
    }
}
