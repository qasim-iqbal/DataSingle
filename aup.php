<!--         
    Author: Group 09
    Filename: privacy_policy.php			
    Date: 2017 - 09 - 18			
    Description: Privacy page for the website, contains css and links			
-->

<?php 
    $title="Data Single - Acceptable Use Policy";
    include("header.php");
	
	if (isset($_SESSION['user_type']) && $_SESSION['user_type'] != "" && $_SESSION['user_type'] == DISABLED.CLIENT)
	{
		$_SESSION['message'] = DISABLED_USER_AUP;
	}
	
	if(!empty($_SESSION['message']))
	{
		echo $_SESSION['message'];
		unset($_SESSION['message']);
	}
?>


<p><strong>Introduction</strong></p>
This Acceptable Use Policy (“AUP”) sets forth terms and conditions for acceptable access and use of Data Single (Data Single, “we” or “us”) websites and services (collectively, a “Services”) by authorized customers and their users (collectively, “Users”) and supplements any written agreement between Data Single and a User. This AUP is not meant to be exhaustive, but sets forth examples of conduct deemed by Data Single to be inappropriate, improper or harmful to Data Single’s network and Services and thereby prohibited. The restrictions set forth in this AUP shall apply to a User’s employees and any other person or entity that is provided access to the Data Single Services directly or indirectly by a User (the “Affiliates”). By accessing or using the Services, each User acknowledges that it is authorized to enter into this AUP and has read, understood and agrees to comply with the terms of this AUP, will cause its Affiliates comply with this AUP, and will be responsible for violations of this AUP by its Affiliates. If User does not agree to this AUP, then do not use the Services.

We reserve the right to modify this AUP from time to time in our sole discretion without notice; such changes will take effect upon the posting of such revised terms on this website. Accordingly, we recommend that Users check this AUP periodically. A User’s continued access or use of the Services after the posting of such revised terms constitutes the User’s agreement to comply with and to be bound by such revised terms. In the event of any conflict between this AUP and any other policy or agreement referenced herein, this AUP shall govern in the absence of specific language to the contrary in such policy or agreement.

<p><strong>General Conduct</strong></p>
User must access and use the Services for lawful purposes and in a manner consistent with the permitted use of the Services. Unless otherwise expressly permitted in writing by Data Single, User may not assign, transfer, distribute, resell, lease or otherwise provide access to any third party to the Services, or use the Services for the benefit of any third party. User may only use the Services in accordance with this AUP, the Data Single Terms of Use at http://www.Data Single.com/about/terms-of-use/ and your end user agreement with Data Single.

Here’s what we won’t allow:
<p><strong>Disruption</strong></p>

Compromising the integrity of our systems. This could include probing, scanning, or testing the vulnerability of any system or network that hosts our Services.
Tampering with, reverse-engineering, or hacking our Services, circumventing any security or authentication measures, or attempting to gain unauthorized access to the Services, related systems, networks, or data
Modifying, disabling, or compromising the integrity or performance of the Services or related systems, network or data
Deciphering any transmissions to or from the servers running the Services
Overwhelming or attempting to overwhelm our infrastructure by imposing an unreasonably large load on our systems that consume extraordinary resources (CPUs, memory, disk space, bandwidth, etc.), such as:
Using “robots,” “spiders,” “offline readers,” or other automated systems to sends more request messages to our servers than a human could reasonably send in the same period of time by using a normal browser
Going far beyond the use parameters for any given service as described in its corresponding documentation
Consuming an unreasonable amount of storage for music, videos, pornography, etc., in a way that’s unrelated to the purposes for which the Services were designed
<p><strong>Wrongful activities</strong></p>

Misrepresentation of yourself, or disguising the origin of any content (including by “spoofing”, “phishing”, manipulating headers or other identifiers, impersonating anyone else, or falsely implying any sponsorship or association with Data Single or any third party)
Using the Services to violate the privacy of others, including publishing or posting other people’s private and confidential information without their express permission, or collecting or gathering other people’s personal information (including account names or information) from our Services
Using our Services to stalk, harass, or post direct, specific threats of violence against others
Using the Services for any illegal purpose, or in violation of any laws (including without limitation data, privacy, and export control laws)
Accessing or searching any part of the Services by any means other than our publicly supported interfaces (for example, “scraping”)
Using meta tags or any other “hidden text” including Data Single’s or our suppliers’ product names or trademarks
<p><strong>Inappropriate communications</strong></p>

Using the Services to generate or send unsolicited communications, advertising, chain letters, or spam
Soliciting our users for commercial purposes, unless expressly permitted by Data Single
Disparaging Data Single or our partners, vendors, or affiliates
Promoting or advertising products or Services other than your own without appropriate authorization
<p><strong>Inappropriate content</strong></p>
Posting, uploading, sharing, submitting, or otherwise providing content that:
Infringes Data Single’s or a third party’s intellectual property or other rights, including any copyright, trademark, patent, trade secret, moral rights, privacy rights of publicity, or any other intellectual property right or proprietary or contractual right
You don’t have the right to submit
Is deceptive, fraudulent, illegal, obscene, defamatory, libelous, threatening, harmful to minors, pornographic (including child pornography, which we will remove and report to law enforcement, including the National Center for Missing and Exploited Children), indecent, harassing, hateful
Encourages illegal or tortious conduct or that is otherwise inappropriate
Attacks others based on their race, ethnicity, national origin, religion, sex, gender, sexual orientation, disability, or medical condition
Contains viruses, bots, worms, scripting exploits, or other similar materials
Is intended to be inflammatory
Could otherwise cause damage to Data Single or any third party
In this AUP, the term “content” means: (1) any information, data, text, software, code, scripts, music, sound, photos, graphics, videos, messages, tags, interactive features, or other materials that you post, upload, share, submit, or otherwise provide in any manner to the Services and (2) any other materials, content, or data you provide to Data Single or use with the Services.

Without affecting any other remedies available to us, Data Single may permanently or temporarily terminate or suspend a User’s account or access to the Services without notice or liability if Data Single (in its sole discretion) determines that a User or its Affiliates has violated this AUP and reserves the right to cooperate with legal authorities and third parties in the investigation of alleged wrongdoing. Data Single shall not be liable for any damages of any nature suffered by any User, Affiliates, or any third party resulting in whole or in part from our exercise of our rights under this AUP. User agrees to indemnify Data Single for any and all damages, claims, suits, costs or expenses asserted against or incurred by Data Single related to or in connection with a violation of this AUP by User or its Affiliates.

The Services are developed and controlled by Data Single in The Commonwealth of Massachusetts, USA. User agrees that this AUP and User’s use of the Services will be governed by the laws of The Commonwealth of Massachusetts, USA, without giving effect to its principles of conflicts of laws. User expressly agrees that the exclusive jurisdiction for any claim or action arising out of or relating to this AUP or User’s or its Affiliate’s use of the Services shall be filed only in the state or federal courts located in The Commonwealth of Massachusetts, and User further agrees and submits to the exercise of personal jurisdiction of such courts for the purpose of litigating any such claim or action. Those who choose to access this site from locations outside of Massachusetts are responsible for compliance with all applicable local laws. If Data Single takes action against User as a result of User’s or its Affiliate’s violation of this AUP, Data Single will be entitled to recover from User, and User agrees to pay, Data Single’s reasonable attorneys’ fees and costs incurred in connection with such action, in addition to any other relief granted to Data Single. Our failure to act with respect to a breach by User or its Affiliates of the terms and conditions hereof shall not constitute a wavier of our rights with respect to such breach or subsequent breaches

<?php include 'footer.php'?>