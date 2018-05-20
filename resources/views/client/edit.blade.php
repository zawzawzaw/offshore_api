@extends('layouts.master')

@section('content')	
	
	<div class="container">
		<div class="row">
			<div class="col-md-8">				
				<div class="space50"></div>

				<h1>Edit Person</h1>				
				<a href="{{ route('officiumtutus.client.index') }}"><button class="custom-submit-class">Return to person database</button></a>

				{{ Form::open([ 'route' => ['officiumtutus.client.update', $person->id ], 'method' => 'put', 'id' => 'edit_client' ]) }}	
					<div class="space50"></div>
					<div class="labels">
						<input type="hidden" name="person_role" value="{{ $person->person_role }}">
						<div class="row">
							<div class="col-md-4"><p>Person code</p></div>
							<div class="col-md-8"><input type="text" name="person_code" value="{{ $person->person_code }}"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Person type</p></div>
							<div class="col-md-8">
								{!! Form::select('person_type', [
								   1 => 'Individual',
								   2 => 'Company'
								], $person->person_type) !!}		
							</div>
						</div>						
						<div class="row">
							<div class="col-md-4"><p>Company name</p></div>
							<div class="col-md-8"><input type="text" name="company_name" value="{{ $person->company_name }}"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Jurisdiction</p></div>
							<div class="col-md-8"><input type="text" name="jurisdiction" value="{{ $person->jurisdiction }}"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Company registration number</p></div>
							<div class="col-md-8"><input type="text" name="reg_no" value="{{ $person->reg_no }}"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Title</p></div>
							<div class="col-md-8"><input type="text" name="title" value="{{ $person->title }}"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>First name</p></div>
							<div class="col-md-8"><input type="text" name="first_name" value="{{ $person->first_name }}"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Surname</p></div>
							<div class="col-md-8"><input type="text" name="surname" value="{{ $person->surname }}"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Nationality</p></div>
							<div class="col-md-8"><input type="text" name="nationality" value="{{ $person->nationality }}"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Passport no</p></div>
							<div class="col-md-8"><input type="text" name="passport_no" value="{{ $person->passport_no }}"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Passport expiry</p></div>
							<div class="col-md-8"><input type="text" name="passport_expiry" value="{{ $person->passport_expiry }}"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Tax residence</p></div>
							<div class="col-md-8"><input type="text" name="tax_residence" value="{{ $person->tax_residence }}"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Tax number</p></div>
							<div class="col-md-8"><input type="text" name="tax_number" value="{{ $person->tax_number }}"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Email</p></div>
							<div class="col-md-8"><input type="text" name="email" value="{{ $person->email }}"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Mobile telephone</p></div>
							<div class="col-md-8"><input type="text" name="mobile_telephone" value="{{ $person->mobile_telephone }}"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Business telephone</p></div>
							<div class="col-md-8"><input type="text" name="work_telephone" value="{{ $person->work_telephone }}"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Home telephone</p></div>
							<div class="col-md-8"><input type="text" name="home_telephone" value="{{ $person->home_telephone }}"></div>
						</div>
						<fieldset>
							<legend>Home address</legend>
							<div class="row">
								<div class="col-md-4"><p>Line 1</p></div>
								<div class="col-md-8"><input type="text" name="home_address" value="{{ $person->home_address }}"></div>
							</div>
							<div class="row">
								<div class="col-md-4"><p>Line 2</p></div>
								<div class="col-md-8"><input type="text" name="home_address_2" value="{{ $person->home_address_2 }}"></div>
							</div>
							<div class="row">
								<div class="col-md-4"><p>City</p></div>
								<div class="col-md-8"><input type="text" name="home_address_3" value="{{ $person->home_address_3 }}"></div>
							</div>
							<div class="row">
								<div class="col-md-4"><p>Postcode</p></div>
								<div class="col-md-8"><input type="text" name="home_address_5" value="{{ $person->home_address_5 }}"></div>
							</div>
							<div class="row">
								<div class="col-md-4"><p>Country</p></div>
								<div class="col-md-8"><select name="home_address_6" value="{{ $person->home_address_6 }}"><option value="">Country</option> <option value="Albania">Albania</option> <option value="Algeria">Algeria</option> <option value="American Samoa">American Samoa</option> <option value="Andorra">Andorra</option> <option value="Angola">Angola</option> <option value="Anguilla">Anguilla</option> <option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option> <option value="Argentina">Argentina</option> <option value="Armenia">Armenia</option> <option value="Aruba">Aruba</option> <option value="Australia">Australia</option> <option value="Austria">Austria</option> <option value="Azerbaijan">Azerbaijan</option> <option value="Bahamas">Bahamas</option> <option value="Bahrain">Bahrain</option> <option value="Bangladesh">Bangladesh</option> <option value="Barbados">Barbados</option> <option value="Belarus">Belarus</option> <option value="Belgium">Belgium</option> <option value="Belize">Belize</option> <option value="Benin">Benin</option> <option value="Bermuda">Bermuda</option> <option value="Bhutan">Bhutan</option> <option value="Bolivia">Bolivia</option> <option value="Bonaire">Bonaire</option> <option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option> <option value="Botswana">Botswana</option> <option value="Brazil">Brazil</option> <option value="British Indian Ocean Ter">British Indian Ocean Ter</option> <option value="Brunei">Brunei</option> <option value="Bulgaria">Bulgaria</option> <option value="Burkina Faso">Burkina Faso</option> <option value="Burundi">Burundi</option> <option value="Cameroon">Cameroon</option> <option value="Canada">Canada</option> <option value="Canary Islands">Canary Islands</option> <option value="Cape Verde">Cape Verde</option> <option value="Cayman Islands">Cayman Islands</option> <option value="Central African Republic">Central African Republic</option> <option value="Chad">Chad</option> <option value="Channel Islands">Channel Islands</option> <option value="Chile">Chile</option> <option value="China">China</option> <option value="Christmas Island">Christmas Island</option> <option value="Cocos Island">Cocos Island</option> <option value="Colombia">Colombia</option> <option value="Comoros">Comoros</option> <option value="Cook Islands">Cook Islands</option> <option value="Costa Rica">Costa Rica</option> <option value="Cote D`Ivoire">Cote D`Ivoire</option> <option value="Croatia">Croatia</option> <option value="Curacao">Curacao</option> <option value="Cyprus">Cyprus</option> <option value="Czech Republic">Czech Republic</option> <option value="Denmark">Denmark</option> <option value="Djibouti">Djibouti</option> <option value="Dominica">Dominica</option> <option value="Dominican Republic">Dominican Republic</option> <option value="East Timor">East Timor</option> <option value="Ecuador">Ecuador</option> <option value="Egypt">Egypt</option> <option value="El Salvador">El Salvador</option> <option value="Equatorial Guinea">Equatorial Guinea</option> <option value="Estonia">Estonia</option> <option value="Ethiopia">Ethiopia</option> <option value="Falkland Islands">Falkland Islands</option> <option value="Faroe Islands">Faroe Islands</option> <option value="Fiji">Fiji</option> <option value="Finland">Finland</option> <option value="France">France</option> <option value="French Guiana">French Guiana</option> <option value="French Polynesia">French Polynesia</option> <option value="French Southern Ter">French Southern Ter</option> <option value="Gabon">Gabon</option> <option value="Gambia">Gambia</option> <option value="Georgia">Georgia</option> <option value="Germany">Germany</option> <option value="Gibraltar">Gibraltar</option> <option value="Great Britain">Great Britain</option> <option value="Greece">Greece</option> <option value="Greenland">Greenland</option> <option value="Grenada">Grenada</option> <option value="Guadeloupe">Guadeloupe</option> <option value="Guam">Guam</option> <option value="Guatemala">Guatemala</option> <option value="Guinea">Guinea</option> <option value="Guyana">Guyana</option> <option value="Haiti">Haiti</option> <option value="Hawaii">Hawaii</option> <option value="Honduras">Honduras</option> <option value="Hong Kong">Hong Kong</option> <option value="Hungary">Hungary</option> <option value="Iceland">Iceland</option> <option value="India">India</option> <option value="Indonesia">Indonesia</option> <option value="Ireland">Ireland</option> <option value="Isle of Man">Isle of Man</option> <option value="Israel">Israel</option> <option value="Italy">Italy</option> <option value="Jamaica">Jamaica</option> <option value="Japan">Japan</option> <option value="Jordan">Jordan</option> <option value="Kazakhstan">Kazakhstan</option> <option value="Kenya">Kenya</option> <option value="Kiribati">Kiribati</option> <option value="Korea South">Korea South</option> <option value="Kuwait">Kuwait</option> <option value="Kyrgyzstan">Kyrgyzstan</option>  <option value="Lebanon">Lebanon</option> <option value="Lesotho">Lesotho</option> <option value="Liechtenstein">Liechtenstein</option> <option value="Lithuania">Lithuania</option> <option value="Luxembourg">Luxembourg</option> <option value="Macau">Macau</option> <option value="Macedonia">Macedonia</option> <option value="Madagascar">Madagascar</option> <option value="Malaysia">Malaysia</option> <option value="Malawi">Malawi</option> <option value="Maldives">Maldives</option> <option value="Mali">Mali</option> <option value="Malta">Malta</option> <option value="Marshall Islands">Marshall Islands</option> <option value="Martinique">Martinique</option> <option value="Mauritania">Mauritania</option> <option value="Mauritius">Mauritius</option> <option value="Mayotte">Mayotte</option> <option value="Mexico">Mexico</option> <option value="Midway Islands">Midway Islands</option> <option value="Moldova">Moldova</option> <option value="Monaco">Monaco</option> <option value="Mongolia">Mongolia</option> <option value="Montserrat">Montserrat</option> <option value="Morocco">Morocco</option> <option value="Mozambique">Mozambique</option>  <option value="Nambia">Nambia</option> <option value="Nauru">Nauru</option> <option value="Nepal">Nepal</option> <option value="Netherland Antilles">Netherland Antilles</option> <option value="Netherlands">Netherlands</option> <option value="Nevis">Nevis</option> <option value="New Caledonia">New Caledonia</option> <option value="New Zealand">New Zealand</option> <option value="Nicaragua">Nicaragua</option> <option value="Niger">Niger</option> <option value="Niue">Niue</option> <option value="Norfolk Island">Norfolk Island</option> <option value="Norway">Norway</option> <option value="Oman">Oman</option> <option value="Palau Island">Palau Island</option> <option value="Palestine">Palestine</option> <option value="Panama">Panama</option> <option value="Papua New Guinea">Papua New Guinea</option> <option value="Paraguay">Paraguay</option> <option value="Peru">Peru</option> <option value="Phillipines">Philippines</option> <option value="Pitcairn Island">Pitcairn Island</option> <option value="Poland">Poland</option> <option value="Portugal">Portugal</option> <option value="Puerto Rico">Puerto Rico</option> <option value="Qatar">Qatar</option> <option value="Republic of Montenegro">Republic of Montenegro</option> <option value="Republic of Serbia">Republic of Serbia</option> <option value="Reunion">Reunion</option> <option value="Romania">Romania</option> <option value="Russia">Russia</option> <option value="Rwanda">Rwanda</option> <option value="St Barthelemy">St Barthelemy</option> <option value="St Eustatius">St Eustatius</option> <option value="St Helena">St Helena</option> <option value="St Kitts-Nevis">St Kitts-Nevis</option> <option value="St Lucia">St Lucia</option> <option value="St Maarten">St Maarten</option> <option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option> <option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option> <option value="Saipan">Saipan</option> <option value="Samoa">Samoa</option> <option value="Samoa American">Samoa American</option> <option value="San Marino">San Marino</option> <option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option> <option value="Senegal">Senegal</option> <option value="Serbia">Serbia</option> <option value="Seychelles">Seychelles</option> <option value="Sierra Leone">Sierra Leone</option> <option value="Singapore">Singapore</option> <option value="Slovakia">Slovakia</option> <option value="Slovenia">Slovenia</option> <option value="Solomon Islands">Solomon Islands</option> <option value="South Africa">South Africa</option> <option value="Spain">Spain</option> <option value="Sri Lanka">Sri Lanka</option> <option value="Suriname">Suriname</option> <option value="Swaziland">Swaziland</option> <option value="Sweden">Sweden</option> <option value="Switzerland">Switzerland</option> <option value="Tahiti">Tahiti</option> <option value="Taiwan">Taiwan</option> <option value="Tajikistan">Tajikistan</option> <option value="Tanzania">Tanzania</option> <option value="Thailand">Thailand</option> <option value="Togo">Togo</option> <option value="Tokelau">Tokelau</option> <option value="Tonga">Tonga</option> <option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option> <option value="Tunisia">Tunisia</option> <option value="Turkey">Turkey</option> <option value="Turkmenistan">Turkmenistan</option> <option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option> <option value="Tuvalu">Tuvalu</option> <option value="Uganda">Uganda</option> <option value="Ukraine">Ukraine</option> <option value="United Arab Emirates">United Arab Emirates</option> <option value="United Kingdom">United Kingdom</option> <option value="United States of America">United States of America</option> <option value="Uruguay">Uruguay</option> <option value="Uzbekistan">Uzbekistan</option> <option value="Vanuatu">Vanuatu</option> <option value="Vatican City State">Vatican City State</option> <option value="Venezuela">Venezuela</option> <option value="Vietnam">Vietnam</option> <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option> <option value="Virgin Islands (USA)">Virgin Islands (USA)</option> <option value="Wake Island">Wake Island</option> <option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option> <option value="Zaire">Zaire</option> <option value="Zambia">Zambia</option> <option value="Zimbabwe">Zimbabwe</option></select></div>
							</div>
						</fieldset>		
						<fieldset>
							<legend>Postal address</legend>				
							<div class="row">
								<div class="col-md-4"><p>Line 1</p></div>
								<div class="col-md-8"><input type="text" name="postal_address" value="{{ $person->postal_address }}"></div>
							</div>
							<div class="row">
								<div class="col-md-4"><p>Line 2</p></div>
								<div class="col-md-8"><input type="text" name="postal_address_2" value="{{ $person->postal_address_2 }}"></div>
							</div>
							<div class="row">
								<div class="col-md-4"><p>City</p></div>
								<div class="col-md-8"><input type="text" name="postal_address_3" value="{{ $person->postal_address_3 }}"></div>
							</div>
							<div class="row">
								<div class="col-md-4"><p>Postcode</p></div>
								<div class="col-md-8"><input type="text" name="postal_address_5" value="{{ $person->postal_address_5 }}"></div>
							</div>
							<div class="row">
								<div class="col-md-4"><p>Country</p></div>
								<div class="col-md-8"><select name="postal_address_6" value="{{ $person->postal_address_6 }}"><option value="">Country</option> <option value="Albania">Albania</option> <option value="Algeria">Algeria</option> <option value="American Samoa">American Samoa</option> <option value="Andorra">Andorra</option> <option value="Angola">Angola</option> <option value="Anguilla">Anguilla</option> <option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option> <option value="Argentina">Argentina</option> <option value="Armenia">Armenia</option> <option value="Aruba">Aruba</option> <option value="Australia">Australia</option> <option value="Austria">Austria</option> <option value="Azerbaijan">Azerbaijan</option> <option value="Bahamas">Bahamas</option> <option value="Bahrain">Bahrain</option> <option value="Bangladesh">Bangladesh</option> <option value="Barbados">Barbados</option> <option value="Belarus">Belarus</option> <option value="Belgium">Belgium</option> <option value="Belize">Belize</option> <option value="Benin">Benin</option> <option value="Bermuda">Bermuda</option> <option value="Bhutan">Bhutan</option> <option value="Bolivia">Bolivia</option> <option value="Bonaire">Bonaire</option> <option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option> <option value="Botswana">Botswana</option> <option value="Brazil">Brazil</option> <option value="British Indian Ocean Ter">British Indian Ocean Ter</option> <option value="Brunei">Brunei</option> <option value="Bulgaria">Bulgaria</option> <option value="Burkina Faso">Burkina Faso</option> <option value="Burundi">Burundi</option> <option value="Cameroon">Cameroon</option> <option value="Canada">Canada</option> <option value="Canary Islands">Canary Islands</option> <option value="Cape Verde">Cape Verde</option> <option value="Cayman Islands">Cayman Islands</option> <option value="Central African Republic">Central African Republic</option> <option value="Chad">Chad</option> <option value="Channel Islands">Channel Islands</option> <option value="Chile">Chile</option> <option value="China">China</option> <option value="Christmas Island">Christmas Island</option> <option value="Cocos Island">Cocos Island</option> <option value="Colombia">Colombia</option> <option value="Comoros">Comoros</option> <option value="Cook Islands">Cook Islands</option> <option value="Costa Rica">Costa Rica</option> <option value="Cote D`Ivoire">Cote D`Ivoire</option> <option value="Croatia">Croatia</option> <option value="Curacao">Curacao</option> <option value="Cyprus">Cyprus</option> <option value="Czech Republic">Czech Republic</option> <option value="Denmark">Denmark</option> <option value="Djibouti">Djibouti</option> <option value="Dominica">Dominica</option> <option value="Dominican Republic">Dominican Republic</option> <option value="East Timor">East Timor</option> <option value="Ecuador">Ecuador</option> <option value="Egypt">Egypt</option> <option value="El Salvador">El Salvador</option> <option value="Equatorial Guinea">Equatorial Guinea</option> <option value="Estonia">Estonia</option> <option value="Ethiopia">Ethiopia</option> <option value="Falkland Islands">Falkland Islands</option> <option value="Faroe Islands">Faroe Islands</option> <option value="Fiji">Fiji</option> <option value="Finland">Finland</option> <option value="France">France</option> <option value="French Guiana">French Guiana</option> <option value="French Polynesia">French Polynesia</option> <option value="French Southern Ter">French Southern Ter</option> <option value="Gabon">Gabon</option> <option value="Gambia">Gambia</option> <option value="Georgia">Georgia</option> <option value="Germany">Germany</option> <option value="Gibraltar">Gibraltar</option> <option value="Great Britain">Great Britain</option> <option value="Greece">Greece</option> <option value="Greenland">Greenland</option> <option value="Grenada">Grenada</option> <option value="Guadeloupe">Guadeloupe</option> <option value="Guam">Guam</option> <option value="Guatemala">Guatemala</option> <option value="Guinea">Guinea</option> <option value="Guyana">Guyana</option> <option value="Haiti">Haiti</option> <option value="Hawaii">Hawaii</option> <option value="Honduras">Honduras</option> <option value="Hong Kong">Hong Kong</option> <option value="Hungary">Hungary</option> <option value="Iceland">Iceland</option> <option value="India">India</option> <option value="Indonesia">Indonesia</option> <option value="Ireland">Ireland</option> <option value="Isle of Man">Isle of Man</option> <option value="Israel">Israel</option> <option value="Italy">Italy</option> <option value="Jamaica">Jamaica</option> <option value="Japan">Japan</option> <option value="Jordan">Jordan</option> <option value="Kazakhstan">Kazakhstan</option> <option value="Kenya">Kenya</option> <option value="Kiribati">Kiribati</option> <option value="Korea South">Korea South</option> <option value="Kuwait">Kuwait</option> <option value="Kyrgyzstan">Kyrgyzstan</option>  <option value="Lebanon">Lebanon</option> <option value="Lesotho">Lesotho</option> <option value="Liechtenstein">Liechtenstein</option> <option value="Lithuania">Lithuania</option> <option value="Luxembourg">Luxembourg</option> <option value="Macau">Macau</option> <option value="Macedonia">Macedonia</option> <option value="Madagascar">Madagascar</option> <option value="Malaysia">Malaysia</option> <option value="Malawi">Malawi</option> <option value="Maldives">Maldives</option> <option value="Mali">Mali</option> <option value="Malta">Malta</option> <option value="Marshall Islands">Marshall Islands</option> <option value="Martinique">Martinique</option> <option value="Mauritania">Mauritania</option> <option value="Mauritius">Mauritius</option> <option value="Mayotte">Mayotte</option> <option value="Mexico">Mexico</option> <option value="Midway Islands">Midway Islands</option> <option value="Moldova">Moldova</option> <option value="Monaco">Monaco</option> <option value="Mongolia">Mongolia</option> <option value="Montserrat">Montserrat</option> <option value="Morocco">Morocco</option> <option value="Mozambique">Mozambique</option>  <option value="Nambia">Nambia</option> <option value="Nauru">Nauru</option> <option value="Nepal">Nepal</option> <option value="Netherland Antilles">Netherland Antilles</option> <option value="Netherlands">Netherlands</option> <option value="Nevis">Nevis</option> <option value="New Caledonia">New Caledonia</option> <option value="New Zealand">New Zealand</option> <option value="Nicaragua">Nicaragua</option> <option value="Niger">Niger</option> <option value="Niue">Niue</option> <option value="Norfolk Island">Norfolk Island</option> <option value="Norway">Norway</option> <option value="Oman">Oman</option> <option value="Palau Island">Palau Island</option> <option value="Palestine">Palestine</option> <option value="Panama">Panama</option> <option value="Papua New Guinea">Papua New Guinea</option> <option value="Paraguay">Paraguay</option> <option value="Peru">Peru</option> <option value="Phillipines">Philippines</option> <option value="Pitcairn Island">Pitcairn Island</option> <option value="Poland">Poland</option> <option value="Portugal">Portugal</option> <option value="Puerto Rico">Puerto Rico</option> <option value="Qatar">Qatar</option> <option value="Republic of Montenegro">Republic of Montenegro</option> <option value="Republic of Serbia">Republic of Serbia</option> <option value="Reunion">Reunion</option> <option value="Romania">Romania</option> <option value="Russia">Russia</option> <option value="Rwanda">Rwanda</option> <option value="St Barthelemy">St Barthelemy</option> <option value="St Eustatius">St Eustatius</option> <option value="St Helena">St Helena</option> <option value="St Kitts-Nevis">St Kitts-Nevis</option> <option value="St Lucia">St Lucia</option> <option value="St Maarten">St Maarten</option> <option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option> <option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option> <option value="Saipan">Saipan</option> <option value="Samoa">Samoa</option> <option value="Samoa American">Samoa American</option> <option value="San Marino">San Marino</option> <option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option> <option value="Senegal">Senegal</option> <option value="Serbia">Serbia</option> <option value="Seychelles">Seychelles</option> <option value="Sierra Leone">Sierra Leone</option> <option value="Singapore">Singapore</option> <option value="Slovakia">Slovakia</option> <option value="Slovenia">Slovenia</option> <option value="Solomon Islands">Solomon Islands</option> <option value="South Africa">South Africa</option> <option value="Spain">Spain</option> <option value="Sri Lanka">Sri Lanka</option> <option value="Suriname">Suriname</option> <option value="Swaziland">Swaziland</option> <option value="Sweden">Sweden</option> <option value="Switzerland">Switzerland</option> <option value="Tahiti">Tahiti</option> <option value="Taiwan">Taiwan</option> <option value="Tajikistan">Tajikistan</option> <option value="Tanzania">Tanzania</option> <option value="Thailand">Thailand</option> <option value="Togo">Togo</option> <option value="Tokelau">Tokelau</option> <option value="Tonga">Tonga</option> <option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option> <option value="Tunisia">Tunisia</option> <option value="Turkey">Turkey</option> <option value="Turkmenistan">Turkmenistan</option> <option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option> <option value="Tuvalu">Tuvalu</option> <option value="Uganda">Uganda</option> <option value="Ukraine">Ukraine</option> <option value="United Arab Emirates">United Arab Emirates</option> <option value="United Kingdom">United Kingdom</option> <option value="United States of America">United States of America</option> <option value="Uruguay">Uruguay</option> <option value="Uzbekistan">Uzbekistan</option> <option value="Vanuatu">Vanuatu</option> <option value="Vatican City State">Vatican City State</option> <option value="Venezuela">Venezuela</option> <option value="Vietnam">Vietnam</option> <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option> <option value="Virgin Islands (USA)">Virgin Islands (USA)</option> <option value="Wake Island">Wake Island</option> <option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option> <option value="Zaire">Zaire</option> <option value="Zambia">Zambia</option> <option value="Zimbabwe">Zimbabwe</option></select></div>
							</div>
						</fieldset>
						<div class="row">
							<div class="col-md-4"><p>Preferred currency </p></div>
							<div class="col-md-8">
								<select name="preferred_currency" value="{{ $person->preferred_currency }}">
									<option selected="selected" value="US dollars (US$)">US dollars (US$)</option>
									<option value="Euro (€)">Euro (€)</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Account registered</p></div>
							<div class="col-md-8"><input type="text" name="account_registered" value="{{ $person->account_registered }}"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Login IP at registration</p></div>
							<div class="col-md-8"><p>{{ "" }}</p></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Relationship commenced </p></div>
							<div class="col-md-8"><input type="text" name="relationship_commenced" value="{{ $person->relationship_commenced }}"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Relationship ended </p></div>
							<div class="col-md-8"><input type="text" name="relationship_ended" value="{{ $person->relationship_ended }}"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Passport copy</p></div>
							<div class="col-md-8"><input type="text" name="passport_copy" value="{{ $person->passport_copy }}"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Proof of address</p></div>
							<div class="col-md-8"><input type="text" name="proof_of_address" value="{{ $person->proof_of_address }}"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Bank reference</p></div>
							<div class="col-md-8"><input type="text" name="bank_reference" value="{{ $person->bank_reference }}"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Professional reference</p></div>
							<div class="col-md-8"><input type="text" name="professional_reference" value="{{ $person->professional_reference }}"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Notes</p></div>
							<div class="col-md-8"><textarea name="notes" id="notes" cols="30" rows="10">{{ $person->notes }}</textarea></div>
						</div>
					</div>
					{{ Form::submit('Save', ['class'=>'custom-submit-class']) }}
				{{ Form::close() }}
				
				<div class="space50"></div>

			</div>
		</div>
	</div>

@endsection