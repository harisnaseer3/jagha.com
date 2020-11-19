<div class="search-section search-area-2 bg-grea sa2 agency-search2-filter">
    <div class="container">
        <div class="search-section-area">
            <div class="search-area-inner">
                <div class="search-contents">
                    {{ Form::open(['route' => 'partners.name.search', 'method' => 'post', 'role' => 'form', 'class' => 'agency-index-form-2']) }}
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                            <div class="form-group">
                                <div class="index-page-select p-0">
                                    <label class="search2-input-label" for="search2-city">CITY</label>
                                    <select class="custom-select custom-select-lg select2bs4 select2-hidden-accessible city-select2" id="search2-city" style="width: 100%; border: 0" tabindex="-1"
                                            aria-hidden="true" aria-describedby="city-error" aria-invalid="false" name="city" required>
{{--                                        <option value selected disabled data-index="0">Select city</option>--}}
                                        @foreach(['islamabad' => 'Islamabad', 'karachi' => 'Karachi', 'lahore' => 'Lahore', 'rawalpindi' => 'Rawalpindi', 'abbottabad' => 'Abbottabad', 'abdul_hakim' => 'Abdul Hakim', 'ahmedpur east' => 'Ahmedpur East', 'alipur' => 'Alipur', 'arifwala' => 'Arifwala', 'astore' => 'Astore', 'attock' => 'Attock', 'awaran' => 'Awaran', 'badin' => 'Badin', 'bagh' => 'Bagh', 'bahawalnagar' => 'Bahawalnagar', 'bahawalpur' => 'Bahawalpur', 'balakot' => 'Balakot', 'bannu' => 'Bannu', 'barnala' => 'Barnala', 'batkhela' => 'Batkhela', 'bhakkar' => 'Bhakkar', 'bhalwal' => 'Bhalwal', 'bhimber' => 'Bhimber', 'buner' => 'Buner', 'burewala' => 'Burewala', 'chaghi' => 'Chaghi', 'chakwal' => 'Chakwal', 'charsadda' => 'Charsadda', 'chichawatni' => 'Chichawatni', 'chiniot' => 'Chiniot', 'chishtian sharif' => 'Chishtian Sharif', 'chitral' => 'Chitral', 'choa_saidan_shah' => 'Choa Saidan Shah', 'chunian' => 'Chunian', 'dadu' => 'Dadu', 'daharki' => 'Daharki', 'daska' => 'Daska', 'daur' => 'Daur', 'depalpur' => 'Depalpur', 'dera_ghazi_khan' => 'Dera Ghazi Khan', 'dera_ismail_khan' => 'Dera Ismail Khan', 'dijkot' => 'Dijkot', 'dina' => 'Dina', 'dobian' => 'Dobian', 'duniya_pur' => 'Duniya Pur', 'fata' => 'FATA', 'faisalabad' => 'Faisalabad', 'fateh_jang' => 'Fateh Jang', 'gaarho' => 'Gaarho', 'gadoon' => 'Gadoon', 'galyat' => 'Galyat', 'ghakhar' => 'Ghakhar', 'gharo' => 'Gharo', 'ghotki' => 'Ghotki', 'gilgit' => 'Gilgit', 'gojra' => 'Gojra', 'gujar_khan' => 'Gujar Khan', 'gujranwala' => 'Gujranwala', 'gujrat' => 'Gujrat', 'gwadar' => 'Gwadar', 'hafizabad' => 'Hafizabad', 'hala' => 'Hala', 'hangu' => 'Hangu', 'harappa' => 'Harappa', 'haripur' => 'Haripur', 'haroonabad' => 'Haroonabad', 'hasilpur' => 'Hasilpur', 'hassan_abdal' => 'Hassan Abdal', 'haveli_lakha' => 'Haveli Lakha', 'hazro' => 'Hazro', 'hub_chowki' => 'Hub Chowki', 'hujra_shah_muqeem' => 'Hujra Shah Muqeem', 'hunza' => 'Hunza', 'hyderabad' => 'Hyderabad', 'islamabad' => 'Islamabad', 'jacobabad' => 'Jacobabad', 'jahanian' => 'Jahanian', 'jalalpur_jattan' => 'Jalalpur Jattan', 'jampur' => 'Jampur', 'jamshoro' => 'Jamshoro', 'jatoi' => 'Jatoi', 'jauharabad' => 'Jauharabad', 'jhang' => 'Jhang', 'jhelum' => 'Jhelum', 'kaghan' => 'Kaghan', 'kahror_pakka' => 'Kahror Pakka', 'kalat' => 'Kalat', 'kamalia' => 'Kamalia', 'kamoki' => 'Kamoki', 'kandiaro' => 'Kandiaro', 'karachi' => 'Karachi', 'karak' => 'Karak', 'kasur' => 'Kasur', 'khairpur' => 'Khairpur', 'khanewal' => 'Khanewal', 'khanpur' => 'Khanpur', 'kharian' => 'Kharian', 'khipro' => 'Khipro', 'khushab' => 'Khushab', 'khuzdar' => 'Khuzdar', 'kohat' => 'Kohat', 'kot_addu' => 'Kot Addu', 'kotli' => 'Kotli', 'kotri' => 'Kotri', 'lahore' => 'Lahore', 'lakki_marwat' => 'Lakki Marwat', 'lalamusa' => 'Lalamusa', 'larkana' => 'Larkana', 'lasbela' => 'Lasbela', 'layyah' => 'Layyah', 'liaquatpur' => 'Liaquatpur', 'lodhran' => 'Lodhran', 'loralai' => 'Loralai', 'lower_dir' => 'Lower Dir', 'mailsi' => 'Mailsi', 'makran' => 'Makran', 'malakand' => 'Malakand', 'mandi_bahauddin' => 'Mandi Bahauddin', 'mangla' => 'Mangla', 'mansehra' => 'Mansehra', 'mardan' => 'Mardan', 'matiari' => 'Matiari', 'matli' => 'Matli', 'mian_channu' => 'Mian Channu', 'mianwali' => 'Mianwali', 'mingora' => 'Mingora', 'mirpur' => 'Mirpur', 'mirpur_khas' => 'Mirpur Khas', 'mirpur_sakro' => 'Mirpur Sakro', 'mitha_tiwana' => 'Mitha Tiwana', 'moro' => 'Moro',
                                                           'multan' => 'Multan', 'muridke' => 'Muridke', 'murree' => 'Murree', 'muzaffarabad' => 'Muzaffarabad', 'muzaffargarh' => 'Muzaffargarh', 'nankana_sahib' => 'Nankana Sahib', 'naran' => 'Naran', 'narowal' => 'Narowal', 'nasar_ullah_khan_town' => 'Nasar Ullah Khan Town', 'nasirabad' => 'Nasirabad', 'naushahro_feroze' => 'Naushahro Feroze', 'nawabshah' => 'Nawabshah', 'neelum' => 'Neelum', 'new_mirpur_city' => 'New Mirpur City', 'nowshera' => 'Nowshera', 'okara' => 'Okara', 'others' => 'Others', 'others_azad kashmir' => 'Others Azad Kashmir', 'others_balochistan' => 'Others Balochistan', 'others_gilgit baltistan' => 'Others Gilgit Baltistan', 'others_khyber pakhtunkhwa' => 'Others Khyber Pakhtunkhwa', 'others_punjab' => 'Others Punjab', 'others_sindh' => 'Others Sindh', 'pakpattan' => 'Pakpattan', 'peshawar' => 'Peshawar', 'pind_dadan_khan' => 'Pind Dadan Khan', 'pindi_bhattian' => 'Pindi Bhattian', 'pir_mahal' => 'Pir Mahal', 'qazi_ahmed' => 'Qazi Ahmed', 'quetta' => 'Quetta', 'rahim_yar_khan' => 'Rahim Yar Khan', 'rajana' => 'Rajana', 'rajanpur' => 'Rajanpur', 'ratwal' => 'Ratwal', 'rawalkot' => 'Rawalkot', 'rawalpindi' => 'Rawalpindi', 'rohri' => 'Rohri', 'sadiqabad' => 'Sadiqabad', 'sahiwal' => 'Sahiwal', 'sakrand' => 'Sakrand', 'samundri' => 'Samundri', 'sanghar' => 'Sanghar', 'sarai_alamgir' => 'Sarai Alamgir', 'sargodha' => 'Sargodha', 'sehwan' => 'Sehwan', 'shabqadar' => 'Shabqadar', 'shahdadpur' => 'Shahdadpur', 'shahkot' => 'Shahkot', 'shahpur_chakar' => 'Shahpur Chakar', 'shakargarh' => 'Shakargarh', 'shehr_sultan' => 'Shehr Sultan', 'sheikhupura' => 'Sheikhupura', 'sher_garh' => 'Sher Garh', 'shikarpur' => 'Shikarpur', 'shorkot' => 'Shorkot', 'sialkot' => 'Sialkot', 'sibi' => 'Sibi', 'skardu' => 'Skardu', 'sudhnoti' => 'Sudhnoti', 'sujawal' => 'Sujawal', 'sukkur' => 'Sukkur', 'swabi' => 'Swabi', 'swat' => 'Swat', 'talagang' => 'Talagang', 'tando_adam' => 'Tando Adam', 'tando_allahyar' => 'Tando Allahyar', 'tando_bago' => 'Tando Bago', 'tando_muhammad_khan' => 'Tando Muhammad Khan', 'taxila' => 'Taxila', 'tharparkar' => 'Tharparkar', 'thatta' => 'Thatta', 'toba_tek_singh' => 'Toba Tek Singh', 'turbat' => 'Turbat', 'vehari' => 'Vehari', 'wah' => 'Wah',
                                                            'wazirabad' => 'Wazirabad', 'waziristan' => 'Waziristan', 'yazman' => 'Yazman', 'zhob' => 'Zhob'] as $city)
                                            <option {{isset($agency_city) && $agency_city == $city ?'selected':''}} value="{{ $city }}"
                                                    data-index={{ $city === 'Islamabad' ? '0' : '' }}>
                                                {{ $city}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                            <div class="form-group">
                                <div class="index-page-select p-0">
                                    <label class="search2-input-label" for="search2-title">TITLE</label>
                                    <input type="text" class="search2-index-page-text-area color-555 search-location" id="search2-title" name="title"
                                           value="{{ isset($agency_title) ? $agency_title : ''}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <button class="search-button" style="margin-top:10px;text-transform:none;" type="submit">
                                    <i class="fa fa-search"></i><strong style="color: white">Find</strong>
                                </button>
                            </div>
                        </div>
                    </div>
                    {{ Form::hidden('sort','newest')}}
                    {{ Form::close() }}

                </div>
            </div>
        </div>
    </div>
</div>
