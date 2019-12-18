<template>
  <div class="plyenz-main bg-primary">
    <div class="auth-box card-animation">
      <div class="auth-logo">
        <div class="header-logo logo-type no-margin">
          <a href="/">SampleSite</a>
        </div>
      </div>
      <div class="auth-desc">
        <p class="mb-0">
          <span>Welcome,</span> register now.
        </p>
      </div>
      <form @submit.prevent="createAccount">
        <div class="form-group mb-20">
          <label for="form-name">
            <strong>Full Name</strong>
          </label>
          <input
            type="text"
            class="form-control form-control-pill"
            id="form-name"
            v-model="details.name"
            v-validate="'required'"
            name="name"
          />
        </div>
        <div class="form-group mb-20">
          <label for="form-mail">
            <strong>E-Mail</strong>
          </label>
          <input
            type="email"
            class="form-control form-control-pill"
            id="form-mail"
            v-model="details.email"
            v-validate="'required|email'"
            name="email"
          />
        </div>
        <div class="form-group mb-20">
          <label for="form-pass">
            <strong>Password</strong>
          </label>
          <input
            type="password"
            class="form-control form-control-pill"
            id="form-pass"
            v-model="details.password"
            v-validate="'required|min:6'"
            name="password"
          />
        </div>
        <div class="form-group mb-20">
          <label for="form-pass2">
            <strong>Confirm Password</strong>
          </label>
          <input
            type="password"
            class="form-control form-control-pill"
            id="form-pass2"
            v-model="details.password_confirmation"
            v-validate="'required'"
            name="password_confirmation"
          />
        </div>
        <div class="form-group mb-20">
          <label for="form-phone">
            <strong>Phone</strong>
          </label>
          <input
            type="text"
            class="form-control form-control-pill"
            id="form-phone"
            v-model="details.phone"
            v-validate="'required'"
            name="phone"
          />
        </div>
        <div class="form-group mb-20">
          <label for="form-id-card">
            <strong>Upload your ID Card</strong>
          </label>
          <input
            type="file"
            id="form-id-card"
            v-validate="'required'"
            name="id_card"
            ref="id_card"
            @change="attachFile"
            accept="image/*, application/pdf"
          />
          <label for="form-id-card">{{ details.fileUploadName }}</label>
        </div>
        <div class="form-group mb-20">
          <label for="form-country">
            <strong>Country</strong>
          </label>
          <select
            name="country"
            id="country"
            v-model="details.country"
            class="form-control form-control-pill select-css"
            :class="{'filled': details.country}"
            v-validate="'required'"
          >
            <option :value="null">Select Country</option>
            <option value="Afghanistan">Afghanistan</option>
            <option value="Åland Islands">Åland Islands</option>
            <option value="Albania">Albania</option>
            <option value="Algeria">Algeria</option>
            <option value="American Samoa">American Samoa</option>
            <option value="Andorra">Andorra</option>
            <option value="Angola">Angola</option>
            <option value="Anguilla">Anguilla</option>
            <option value="Antarctica">Antarctica</option>
            <option value="Antigua and Barbuda">Antigua and Barbuda</option>
            <option value="Argentina">Argentina</option>
            <option value="Armenia">Armenia</option>
            <option value="Aruba">Aruba</option>
            <option value="Australia">Australia</option>
            <option value="Austria">Austria</option>
            <option value="Azerbaijan">Azerbaijan</option>
            <option value="Bahamas">Bahamas</option>
            <option value="Bahrain">Bahrain</option>
            <option value="Bangladesh">Bangladesh</option>
            <option value="Barbados">Barbados</option>
            <option value="Belarus">Belarus</option>
            <option value="Belgium">Belgium</option>
            <option value="Belize">Belize</option>
            <option value="Benin">Benin</option>
            <option value="Bermuda">Bermuda</option>
            <option value="Bhutan">Bhutan</option>
            <option value="Bolivia">Bolivia</option>
            <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
            <option value="Botswana">Botswana</option>
            <option value="Bouvet Island">Bouvet Island</option>
            <option value="Brazil">Brazil</option>
            <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
            <option value="Brunei Darussalam">Brunei Darussalam</option>
            <option value="Bulgaria">Bulgaria</option>
            <option value="Burkina Faso">Burkina Faso</option>
            <option value="Burundi">Burundi</option>
            <option value="Cambodia">Cambodia</option>
            <option value="Cameroon">Cameroon</option>
            <option value="Canada">Canada</option>
            <option value="Cape Verde">Cape Verde</option>
            <option value="Cayman Islands">Cayman Islands</option>
            <option value="Central African Republic">Central African Republic</option>
            <option value="Chad">Chad</option>
            <option value="Chile">Chile</option>
            <option value="China">China</option>
            <option value="Christmas Island">Christmas Island</option>
            <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
            <option value="Colombia">Colombia</option>
            <option value="Comoros">Comoros</option>
            <option value="Congo">Congo</option>
            <option
              value="Congo, The Democratic Republic of The"
            >Congo, The Democratic Republic of The</option>
            <option value="Cook Islands">Cook Islands</option>
            <option value="Costa Rica">Costa Rica</option>
            <option value="Cote D'ivoire">Cote D'ivoire</option>
            <option value="Croatia">Croatia</option>
            <option value="Cuba">Cuba</option>
            <option value="Cyprus">Cyprus</option>
            <option value="Czech Republic">Czech Republic</option>
            <option value="Denmark">Denmark</option>
            <option value="Djibouti">Djibouti</option>
            <option value="Dominica">Dominica</option>
            <option value="Dominican Republic">Dominican Republic</option>
            <option value="Ecuador">Ecuador</option>
            <option value="Egypt">Egypt</option>
            <option value="El Salvador">El Salvador</option>
            <option value="Equatorial Guinea">Equatorial Guinea</option>
            <option value="Eritrea">Eritrea</option>
            <option value="Estonia">Estonia</option>
            <option value="Ethiopia">Ethiopia</option>
            <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
            <option value="Faroe Islands">Faroe Islands</option>
            <option value="Fiji">Fiji</option>
            <option value="Finland">Finland</option>
            <option value="France">France</option>
            <option value="French Guiana">French Guiana</option>
            <option value="French Polynesia">French Polynesia</option>
            <option value="French Southern Territories">French Southern Territories</option>
            <option value="Gabon">Gabon</option>
            <option value="Gambia">Gambia</option>
            <option value="Georgia">Georgia</option>
            <option value="Germany">Germany</option>
            <option value="Ghana">Ghana</option>
            <option value="Gibraltar">Gibraltar</option>
            <option value="Greece">Greece</option>
            <option value="Greenland">Greenland</option>
            <option value="Grenada">Grenada</option>
            <option value="Guadeloupe">Guadeloupe</option>
            <option value="Guam">Guam</option>
            <option value="Guatemala">Guatemala</option>
            <option value="Guernsey">Guernsey</option>
            <option value="Guinea">Guinea</option>
            <option value="Guinea-bissau">Guinea-bissau</option>
            <option value="Guyana">Guyana</option>
            <option value="Haiti">Haiti</option>
            <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
            <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
            <option value="Honduras">Honduras</option>
            <option value="Hong Kong">Hong Kong</option>
            <option value="Hungary">Hungary</option>
            <option value="Iceland">Iceland</option>
            <option value="India">India</option>
            <option value="Indonesia">Indonesia</option>
            <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
            <option value="Iraq">Iraq</option>
            <option value="Ireland">Ireland</option>
            <option value="Isle of Man">Isle of Man</option>
            <option value="Israel">Israel</option>
            <option value="Italy">Italy</option>
            <option value="Jamaica">Jamaica</option>
            <option value="Japan">Japan</option>
            <option value="Jersey">Jersey</option>
            <option value="Jordan">Jordan</option>
            <option value="Kazakhstan">Kazakhstan</option>
            <option value="Kenya">Kenya</option>
            <option value="Kiribati">Kiribati</option>
            <option
              value="Korea, Democratic People's Republic of"
            >Korea, Democratic People's Republic of</option>
            <option value="Korea, Republic of">Korea, Republic of</option>
            <option value="Kuwait">Kuwait</option>
            <option value="Kyrgyzstan">Kyrgyzstan</option>
            <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
            <option value="Latvia">Latvia</option>
            <option value="Lebanon">Lebanon</option>
            <option value="Lesotho">Lesotho</option>
            <option value="Liberia">Liberia</option>
            <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
            <option value="Liechtenstein">Liechtenstein</option>
            <option value="Lithuania">Lithuania</option>
            <option value="Luxembourg">Luxembourg</option>
            <option value="Macao">Macao</option>
            <option
              value="Macedonia, The Former Yugoslav Republic of"
            >Macedonia, The Former Yugoslav Republic of</option>
            <option value="Madagascar">Madagascar</option>
            <option value="Malawi">Malawi</option>
            <option value="Malaysia">Malaysia</option>
            <option value="Maldives">Maldives</option>
            <option value="Mali">Mali</option>
            <option value="Malta">Malta</option>
            <option value="Marshall Islands">Marshall Islands</option>
            <option value="Martinique">Martinique</option>
            <option value="Mauritania">Mauritania</option>
            <option value="Mauritius">Mauritius</option>
            <option value="Mayotte">Mayotte</option>
            <option value="Mexico">Mexico</option>
            <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
            <option value="Moldova, Republic of">Moldova, Republic of</option>
            <option value="Monaco">Monaco</option>
            <option value="Mongolia">Mongolia</option>
            <option value="Montenegro">Montenegro</option>
            <option value="Montserrat">Montserrat</option>
            <option value="Morocco">Morocco</option>
            <option value="Mozambique">Mozambique</option>
            <option value="Myanmar">Myanmar</option>
            <option value="Namibia">Namibia</option>
            <option value="Nauru">Nauru</option>
            <option value="Nepal">Nepal</option>
            <option value="Netherlands">Netherlands</option>
            <option value="Netherlands Antilles">Netherlands Antilles</option>
            <option value="New Caledonia">New Caledonia</option>
            <option value="New Zealand">New Zealand</option>
            <option value="Nicaragua">Nicaragua</option>
            <option value="Niger">Niger</option>
            <option value="Nigeria">Nigeria</option>
            <option value="Niue">Niue</option>
            <option value="Norfolk Island">Norfolk Island</option>
            <option value="Northern Mariana Islands">Northern Mariana Islands</option>
            <option value="Norway">Norway</option>
            <option value="Oman">Oman</option>
            <option value="Pakistan">Pakistan</option>
            <option value="Palau">Palau</option>
            <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
            <option value="Panama">Panama</option>
            <option value="Papua New Guinea">Papua New Guinea</option>
            <option value="Paraguay">Paraguay</option>
            <option value="Peru">Peru</option>
            <option value="Philippines">Philippines</option>
            <option value="Pitcairn">Pitcairn</option>
            <option value="Poland">Poland</option>
            <option value="Portugal">Portugal</option>
            <option value="Puerto Rico">Puerto Rico</option>
            <option value="Qatar">Qatar</option>
            <option value="Reunion">Reunion</option>
            <option value="Romania">Romania</option>
            <option value="Russian Federation">Russian Federation</option>
            <option value="Rwanda">Rwanda</option>
            <option value="Saint Helena">Saint Helena</option>
            <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
            <option value="Saint Lucia">Saint Lucia</option>
            <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
            <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
            <option value="Samoa">Samoa</option>
            <option value="San Marino">San Marino</option>
            <option value="Sao Tome and Principe">Sao Tome and Principe</option>
            <option value="Saudi Arabia">Saudi Arabia</option>
            <option value="Senegal">Senegal</option>
            <option value="Serbia">Serbia</option>
            <option value="Seychelles">Seychelles</option>
            <option value="Sierra Leone">Sierra Leone</option>
            <option value="Singapore">Singapore</option>
            <option value="Slovakia">Slovakia</option>
            <option value="Slovenia">Slovenia</option>
            <option value="Solomon Islands">Solomon Islands</option>
            <option value="Somalia">Somalia</option>
            <option value="South Africa">South Africa</option>
            <option
              value="South Georgia and The South Sandwich Islands"
            >South Georgia and The South Sandwich Islands</option>
            <option value="Spain">Spain</option>
            <option value="Sri Lanka">Sri Lanka</option>
            <option value="Sudan">Sudan</option>
            <option value="Suriname">Suriname</option>
            <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
            <option value="Swaziland">Swaziland</option>
            <option value="Sweden">Sweden</option>
            <option value="Switzerland">Switzerland</option>
            <option value="Syrian Arab Republic">Syrian Arab Republic</option>
            <option value="Taiwan, Province of China">Taiwan, Province of China</option>
            <option value="Tajikistan">Tajikistan</option>
            <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
            <option value="Thailand">Thailand</option>
            <option value="Timor-leste">Timor-leste</option>
            <option value="Togo">Togo</option>
            <option value="Tokelau">Tokelau</option>
            <option value="Tonga">Tonga</option>
            <option value="Trinidad and Tobago">Trinidad and Tobago</option>
            <option value="Tunisia">Tunisia</option>
            <option value="Turkey">Turkey</option>
            <option value="Turkmenistan">Turkmenistan</option>
            <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
            <option value="Tuvalu">Tuvalu</option>
            <option value="Uganda">Uganda</option>
            <option value="Ukraine">Ukraine</option>
            <option value="United Arab Emirates">United Arab Emirates</option>
            <option value="United Kingdom">United Kingdom</option>
            <option value="United States">United States</option>
            <option
              value="United States Minor Outlying Islands"
            >United States Minor Outlying Islands</option>
            <option value="Uruguay">Uruguay</option>
            <option value="Uzbekistan">Uzbekistan</option>
            <option value="Vanuatu">Vanuatu</option>
            <option value="Venezuela">Venezuela</option>
            <option value="Viet Nam">Viet Nam</option>
            <option value="Virgin Islands, British">Virgin Islands, British</option>
            <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
            <option value="Wallis and Futuna">Wallis and Futuna</option>
            <option value="Western Sahara">Western Sahara</option>
            <option value="Yemen">Yemen</option>
            <option value="Zambia">Zambia</option>
            <option value="Zimbabwe">Zimbabwe</option>
          </select>
        </div>
        <div class="form-group mb-20">
          <label for="form-currency">
            <strong>Currency</strong>
          </label>
          <select
            name="currency"
            id="currency"
            v-model="details.currency"
            class="form-control form-control-pill select-css"
            :class="{'filled': details.currency}"
            v-validate="'required'"
          >
            <option :value="null">Select Currency</option>
            <option value="USD">USD</option>
            <option value="EUR">EUR</option>
            <option value="JPY">JPY</option>
            <option value="GBP">GBP</option>
            <option value="CAD">CAD</option>
            <option value="CHF">CHF</option>
          </select>
        </div>

        <div class="form-group">
          <label class="control control-checkbox">
            <span class="text-light">Accept terms and conditions</span>
            <input type="checkbox" v-model="details.agreement" />
            <span class="control-icon"></span>
          </label>
        </div>
        <div class="form-group mt-25">
          <button class="btn btn-primary btn-shadow btn-round btn-block">Register</button>
        </div>
        <div>
          <hr />
          <p class="fs-12 text-center text-light">
            Do you have an account?
            <router-link :to="{name:'dashboard.login'}" class="text-primary">Log In</router-link>
          </p>
        </div>
      </form>
    </div>
  </div>
  <!-- main content #end -->
</template>

<script>
  import { siteRegister } from "@dashboard-assets/js/config/endpoints";
  import mixins from "@dashboard-assets/js/config/mixins";
  export default {
    mixins: [mixins],
    data: () => ({
      details: {
        country: null,
        fileUploadName: "Upload your ID Card",
        currency: null
      }
    }),
    mounted() {
      this.$emit("page-loaded");
    },
    methods: {
      attachFile() {
        this.details.fileUploadName = this.$refs.id_card.files[0].name;

        this.details.id_card = this.$refs.id_card.files[0];
      },
      createAccount() {
        BlockToast.fire({
          text: "Setting up user account..."
        });
        let formData = new FormData();

        _.forEach(this.details, (val, key) => {
          formData.append(key, val);
        });

        axios
          .post(siteRegister, formData, {
            headers: {
              "Content-Type": "multipart/form-data"
            }
          })
          .then(rsp => {
            if (rsp && rsp.status == 201) {
              swal
                .fire({
                  title: "Success",
                  text: `Registration successful`,
                  type: "success"
                })
                .then(() => {
                  // location.replace("/login");
                  // swal.close();
                  this.$router.push({ name: "dashboard.login" });
                });
            }
          });
      }
    }
  };
</script>

<style lang="scss" scoped>
  .form-control,
  .btn-round {
    padding: 12px;
  }

  [type="file"] {
    height: 0;
    overflow: hidden;
    width: 0;

    &#file {
      border: none;
      border-radius: 0;
      padding: 0;
    }
  }

  [type="file"] + label {
    // background: #f15d22;
    border: 1px solid #c0c0c0;
    border-radius: 40px;
    color: #686565;
    cursor: pointer;
    display: block;
    font-family: "Poppins", sans-serif;
    font-size: inherit;
    font-weight: 600;
    margin-bottom: 1rem;
    outline: none;
    padding: 0.8rem 20px;
    position: relative;
    transition: all 0.3s;
    vertical-align: middle;
    &:hover {
      background-color: darken(#fff, 5%);
    }
  }

  .select-css {
    height: auto !important;
    display: block;
    font-size: 16px;
    font-family: sans-serif;
    font-weight: 700;
    color: #888;
    line-height: 1.3;
    padding: 12px 12px 12px 20px;
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
    margin: 0;
    border: 1px solid #ebebeb;
    border-radius: 1.5em;
    -moz-appearance: none;
    -webkit-appearance: none;
    appearance: none;
    background-color: #fff;
    background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23007CB2%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E");
    background-repeat: no-repeat, repeat;
    background-position: right 0.7em top 50%, 0 0;
    background-size: 0.65em auto, 100%;
  }
  .select-css::-ms-expand {
    display: none;
  }
  .select-css:hover {
    border-color: darken(#ebebeb, 10%);
  }
  .select-css:focus {
    border-color: darken(#ebebeb, 5%);
    color: darken(#222, 10%);
  }
  .select-css option {
    font-weight: normal;
  }
</style>
