<?php
session_start();
include('include/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Form - Electricians</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<style>
  .service-header {
    background: url('img/bulb.jpg');
    text-align: center;
    background-repeat: no-repeat;
    height: 500px;
    display: flex;
    justify-content: center;
    align-items: center;
    background-position: center;
    color: white;
    background-size: cover;
    position: relative;
}

</style>

</head>
<body>
    <?php

include "config/conn.php";

// Check if the user is logged in
if (!isset($_SESSION['isLoggedIn']) || !$_SESSION['isLoggedIn']) {
    header("Location: login.php");
    exit;
}

// Get the customer's email from the session
$customer_email = $_SESSION['user_email']; // Assuming email is stored in session

// Fetch services from the database
$sql_services = "SELECT id, title FROM services";
$result_services = mysqli_query($conn, $sql_services);
$services = [];

if ($result_services) {
    while ($row = mysqli_fetch_assoc($result_services)) {
        $services[] = $row;
    }
} else {
    $_SESSION['status'] = "Error fetching services: " . mysqli_error($conn);
    header("Location: service_request_form.php");
    exit;
}
?>
<div class="service-header">
    <h2>Welcome, <?php echo $_SESSION['user_name']; ?>! Experience Exceptional Service with OJM – Serving You Better</h2>
</div>


<div class="container mt-5 " style="margin-bottom:100px; ">
    <h2 class="text-center mb-4">Let's Connect You to the Best Electricians Near You</h2>
<?php

include "config/conn.php";

// Check if the user is logged in
if (!isset($_SESSION['isLoggedIn']) || !$_SESSION['isLoggedIn']) {
    header("Location: login.php");
    exit;
}

// Get the customer's email from the session
$customer_email = $_SESSION['user_email']; // Assuming email is stored in session

// Fetch services from the database
$sql_services = "SELECT id, title FROM services";
$result_services = mysqli_query($conn, $sql_services);
$services = [];

if ($result_services) {
    while ($row = mysqli_fetch_assoc($result_services)) {
        $services[] = $row;
    }
} else {
    $_SESSION['status'] = "Error fetching services: " . mysqli_error($conn);
    header("Location: service_request_form.php");
    exit;
}
?>

<form action="service_request.php" method="POST" enctype="multipart/form-data">
    <!-- Country Selection -->
    <div class="mb-3">
        <label for="country" class="form-label">Country</label>
        <select class="form-select" id="country" name="country" required>
            <option value="" selected disabled>Select your country</option>
       <option value="Algeria">Algeria</option>
<option value="Angola">Angola</option>
<option value="Benin">Benin</option>
<option value="Botswana">Botswana</option>
<option value="Burkina Faso">Burkina Faso</option>
<option value="Burundi">Burundi</option>
<option value="Cabo Verde">Cabo Verde</option>
<option value="Cameroon">Cameroon</option>
<option value="Central African Republic">Central African Republic</option>
<option value="Chad">Chad</option>
<option value="Comoros">Comoros</option>
<option value="Congo (Congo-Brazzaville)">Congo (Congo-Brazzaville)</option>
<option value="Côte d'Ivoire">Côte d'Ivoire</option>
<option value="Djibouti">Djibouti</option>
<option value="Egypt">Egypt</option>
<option value="Equatorial Guinea">Equatorial Guinea</option>
<option value="Eritrea">Eritrea</option>
<option value="Eswatini (fmr. 'Swaziland')">Eswatini (fmr. "Swaziland")</option>
<option value="Ethiopia">Ethiopia</option>
<option value="Gabon">Gabon</option>
<option value="Gambia">Gambia</option>
<option value="Ghana">Ghana</option>
<option value="Guinea">Guinea</option>
<option value="Guinea-Bissau">Guinea-Bissau</option>
<option value="Kenya">Kenya</option>
<option value="Lesotho">Lesotho</option>
<option value="Liberia">Liberia</option>
<option value="Libya">Libya</option>
<option value="Madagascar">Madagascar</option>
<option value="Malawi">Malawi</option>
<option value="Mali">Mali</option>
<option value="Mauritania">Mauritania</option>
<option value="Mauritius">Mauritius</option>
<option value="Morocco">Morocco</option>
<option value="Mozambique">Mozambique</option>
<option value="Namibia">Namibia</option>
<option value="Niger">Niger</option>
<option value="Nigeria">Nigeria</option>
<option value="Rwanda">Rwanda</option>
<option value="Sao Tome and Principe">Sao Tome and Principe</option>
<option value="Senegal">Senegal</option>
<option value="Seychelles">Seychelles</option>
<option value="Sierra Leone">Sierra Leone</option>
<option value="Somalia">Somalia</option>
<option value="South Africa">South Africa</option>
<option value="South Sudan">South Sudan</option>
<option value="Sudan">Sudan</option>
<option value="Tanzania">Tanzania</option>
<option value="Togo">Togo</option>
<option value="Tunisia">Tunisia</option>
<option value="Uganda">Uganda</option>
<option value="Zambia">Zambia</option>
<option value="Zimbabwe">Zimbabwe</option>                
            <!-- Add other countries here -->
        </select>
    </div>

    <!-- State Selection -->
    <div class="mb-3" id="state-container" style="display: none;">
        <label for="state" class="form-label">State</label>
        <select class="form-select" id="state" name="state" required>
            <option value="" selected disabled>Select your state</option>
            <!-- States will be populated dynamically based on the country selected -->
        </select>
    </div>

    <!-- City Selection -->
    <div class="mb-3" id="city-container" style="display: none;">
        <label for="city" class="form-label">City</label>
        <select class="form-select" id="city" name="city" required>
            <option value="" selected disabled>Select your city</option>
            <!-- Cities will be populated dynamically based on the state selected -->
        </select>
    </div>

    <!-- Address -->
    <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address" required>
    </div>

    <!-- Electrical Service -->
    <div class="mb-3">
        <label for="service" class="form-label">What electrical service do you need?</label>
        <select class="form-select" id="service" name="service" required>
            <option value="" selected disabled>Select the service you need</option>
            <?php foreach ($services as $service): ?>
                <option value="<?php echo $service['id']; ?>"><?php echo $service['title']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Full Name -->
    <div class="mb-3">
        <label for="fullname" class="form-label">Full Name</label>
        <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter your full name" required>
    </div>

    <!-- Email Address -->
    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($customer_email); ?>" required readonly>
    </div>

    <!-- Phone Number -->
    <div class="mb-3">
        <label for="phone" class="form-label">Phone Number</label>
        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required>
    </div>

    <!-- Job Start Date -->
    <div class="mb-3">
        <label for="job-start" class="form-label">When would you like the job to start?</label>
        <input type="date" class="form-control" id="job-start" name="job-start" required>
    </div>

   <!-- Readiness to Hire -->
<div class="mb-3">
    <label for="readiness_to_hire" class="form-label">Readiness to Hire</label>
    <select class="form-select" id="readiness_to_hire" name="readiness_to_hire">
        <option selected disabled>Select an option</option>
        <option value="Soon">Soon</option>
        <option value="Very Soon">Very Soon</option>
        <option value="Urgent">Urgent</option>
    </select>
</div>



    <!-- Service Description -->
    <div class="mb-3">
        <label for="service-desc" class="form-label">Service Description</label>
        <textarea class="form-control" id="service-desc" name="service-desc" rows="3" placeholder="Describe the service you need" required></textarea>
    </div>

    <div class="mb-3">
        <label for="service_image" class="form-label">Upload an Image (Optional) for more description of your services</label>
        <input type="file" class="form-control" id="service_image" name="service_image">
    </div>

    <!-- Submit Button -->
    <button type="submit" class="btn btn-primary w-100">Submit</button>
</form>
</div>

<!-- Add some modern CSS styles -->
<style>
    .container {
        max-width: 800px;
        margin: auto;
    }
    .form-select, .form-control, .form-check-input {
        border-radius: 8px;
          }
    .form-label {
        font-weight: bold;
        font-size: 16px;
    }
    .btn {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
        font-size: 16px;
        padding: 12px;
    }
    .btn:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
    .form-check-label {
        font-size: 14px;
    }
</style>

    <script>
        // Dummy Data for States and Cities in Nigeria
       const countries = {
    "Nigeria": {
        states: {
            "Abia": [
                "Aba North", "Aba South", "Arochukwu", "Bende", "Ikwuano", 
                "Isiala Ngwa North", "Isiala Ngwa South", "Isuikwuato", 
                "Obi Ngwa", "Ohafia", "Osisioma", "Ugwunagbo", 
                "Ukwa East", "Ukwa West", "Umuahia North", "Umuahia South"
            ],
            "Adamawa": [
                "Demsa", "Fufore", "Ganye", "Gayuk", "Girei", "Gombi", 
                "Hong", "Jada", "Lamurde", "Madagali", "Maiha", "Mayo-Belwa", 
                "Michika", "Mubi North", "Mubi South", "Numan", "Shelleng", 
                "Song", "Toungo", "Yola North", "Yola South"
            ],
            "Akwa Ibom": [
                "Abak", "Eastern Obolo", "Eket", "Esit Eket", "Essien Udim", 
                "Etim Ekpo", "Etinan", "Ibeno", "Ibesikpo Asutan", "Ibiono Ibom", 
                "Ika", "Ikono", "Ikot Abasi", "Ikot Ekpene", "Ini", 
                "Itu", "Mbo", "Mkpat Enin", "Nsit Atai", "Nsit Ibom", 
                "Nsit Ubium", "Obot Akara", "Okobo", "Onna", "Oron", 
                "Oruk Anam", "Udung Uko", "Ukanafun", "Uruan", "Urue-Offong/Oruko", "Uyo"
            ],
            "Anambra": [
                "Aguata", "Anambra East", "Anambra West", "Anaocha", 
                "Awka North", "Awka South", "Ayamelum", "Dunukofia", 
                "Ekwusigo", "Idemili North", "Idemili South", "Ihiala", 
                "Njikoka", "Nnewi North", "Nnewi South", "Ogbaru", 
                "Onitsha North", "Onitsha South", "Orumba North", "Orumba South", "Oyi"
            ],
            "Bauchi": [
                "Alkaleri", "Bauchi", "Bogoro", "Damban", "Darazo", 
                "Dass", "Gamawa", "Ganjuwa", "Giade", "Itas/Gadau", 
                "Jama'are", "Katagum", "Kirfi", "Misau", "Ningi", 
                "Shira", "Tafawa Balewa", "Toro", "Warji", "Zaki"
            ],
            "Bayelsa": [
                "Brass", "Ekeremor", "Kolokuma/Opokuma", "Nembe", 
                "Ogbia", "Sagbama", "Southern Ijaw", "Yenagoa"
            ],
            "Benue": [
                "Ado", "Agatu", "Apa", "Buruku", "Gboko", 
                "Guma", "Gwer East", "Gwer West", "Katsina-Ala", "Konshisha", 
                "Kwande", "Logo", "Makurdi", "Obi", "Ogbadibo", 
                "Oju", "Okpokwu", "Ohimini", "Otukpo", "Tarka", 
                "Ukum", "Ushongo", "Vandeikya"
            ],
            "Borno": [
                "Abadam", "Askira/Uba", "Bama", "Bayo", "Biu", 
                "Chibok", "Damboa", "Dikwa", "Gubio", "Guzamala", 
                "Gwoza", "Hawul", "Jere", "Kaga", "Kala/Balge", 
                "Konduga", "Kukawa", "Kwaya Kusar", "Mafa", "Magumeri", 
                "Maiduguri", "Marte", "Mobbar", "Monguno", "Ngala", 
                "Nganzai", "Shani"
            ],
            "Cross River": [
                "Abi", "Akamkpa", "Akpabuyo", "Bakassi", "Bekwarra", 
                "Biase", "Boki", "Calabar Municipal", "Calabar South", "Etung", 
                "Ikom", "Obanliku", "Obubra", "Obudu", "Odukpani", 
                "Ogoja", "Yakuur", "Yala"
            ],
            "Delta": [
                "Aniocha North", "Aniocha South", "Bomadi", "Burutu", "Ethiope East", 
                "Ethiope West", "Ika North East", "Ika South", "Isoko North", "Isoko South", 
                "Ndokwa East", "Ndokwa West", "Okpe", "Oshimili North", "Oshimili South", 
                "Patani", "Sapele", "Udu", "Ughelli North", "Ughelli South", 
                "Ukwuani", "Uvwie", "Warri North", "Warri South", "Warri South West"
            ],
            "Ebonyi": [
                "Abakaliki", "Afikpo North", "Afikpo South", "Ebonyi", "Ezza North", 
                "Ezza South", "Ikwo", "Ishielu", "Ivo", "Izzi", 
                "Ohaozara", "Ohaukwu", "Onicha"
            ],
            "Edo": [
                "Akoko-Edo", "Egor", "Esan Central", "Esan North-East", "Esan South-East", 
                "Esan West", "Etsako Central", "Etsako East", "Etsako West", "Igueben", 
                "Ikpoba-Okha", "Orhionmwon", "Oredo", "Ovia North-East", "Ovia South-West", 
                "Owan East", "Owan West", "Uhunmwonde"
            ],
            "Ekiti": [
                "Ado Ekiti", "Efon", "Ekiti East", "Ekiti South-West", "Ekiti West", 
                "Emure", "Gbonyin", "Ido Osi", "Ijero", "Ikere", 
                "Ikole", "Ilejemeje", "Irepodun/Ifelodun", "Ise/Orun", "Moba", "Oye"
            ],
            "Enugu": [
                "Aninri", "Awgu", "Enugu East", "Enugu North", "Enugu South", 
                "Ezeagu", "Igbo Etiti", "Igbo Eze North", "Igbo Eze South", "Isi Uzo", 
                "Nkanu East", "Nkanu West", "Nsukka", "Oji River", "Udenu", "Udi", "Uzouwani"
            ],
            "FCT": [
                "Abaji", "Bwari", "Gwagwalada", "Kuje", "Kwali", "Municipal Area Council"
            ],

            "Gombe": [
                "Akko", "Balanga", "Billiri", "Dukku", "Funakaye", 
                "Gombe", "Kaltungo", "Kwami", "Nafada", "Shongom", "Yamaltu/Deba"
            ],
            "Imo": [
                "Aboh Mbaise", "Ahiazu Mbaise", "Ehime Mbano", "Ezinihitte", "Ideato North", 
                "Ideato South", "Ihitte/Uboma", "Ikeduru", "Isiala Mbano", "Isu", 
                "Mbaitoli", "Ngor Okpala", "Njaba", "Nkwerre", "Nwangele", 
                "Obowo", "Oguta", "Ohaji/Egbema", "Okigwe", "Onuimo", 
                "Orlu", "Orsu", "Oru East", "Oru West", "Owerri Municipal", 
                "Owerri North", "Owerri West"
            ],
            "Jigawa": [
                "Auyo", "Babura", "Biriniwa", "Birnin Kudu", "Buji", 
                "Dutse", "Gagarawa", "Garki", "Gumel", "Guri", 
                "Gwaram", "Gwiwa", "Hadejia", "Jahun", "Kafin Hausa", 
                "Kaugama", "Kazaure", "Kirikasamma", "Kiyawa", "Maigatari", 
                "Malam Madori", "Miga", "Ringim", "Roni", "Sule Tankarkar", "Taura", "Yankwashi"
            ],
            "Kaduna": [
                "Birnin Gwari", "Chikun", "Giwa", "Igabi", "Ikara", 
                "Jaba", "Jema'a", "Kachia", "Kaduna North", "Kaduna South", 
                "Kagaroko", "Kajuru", "Kaura", "Kauru", "Kubau", 
                "Kudan", "Lere", "Makarfi", "Sabon Gari", "Sanga", 
                "Soba", "Zangon Kataf", "Zaria"
            ],
            "Kano": [
                "Ajingi", "Albasu", "Bagwai", "Bebeji", "Bichi", 
                "Dala", "Dambatta", "Dawakin Kudu", "Dawakin Tofa", "Doguwa", 
                "Fagge", "Gabasawa", "Garko", "Garun Mallam", "Gaya", 
                "Gezawa", "Gwale", "Gwarzo", "Kabo", "Kano Municipal", 
                "Karaye", "Kibiya", "Kiru", "Kumbotso", "Kunchi", 
                "Kura", "Madobi", "Makoda", "Minjibir", "Nasarawa", 
                "Rano", "Rimin Gado", "Rogo", "Shanono", "Sumaila", 
                "Takai", "Tarauni", "Tofa", "Tsanyawa", "Tudun Wada", "Ungogo", "Warawa", "Wudil"
            ],
            "Katsina": [
                "Bakori", "Batagarawa", "Batsari", "Baure", "Bindawa", 
                "Charanchi", "Dan Musa", "Dandume", "Danja", "Daura", 
                "Dutsi", "Dutsin Ma", "Faskari", "Funtua", "Ingawa", 
                "Jibia", "Kafur", "Kaita", "Kankara", "Kankia", 
                "Katsina", "Kurfi", "Kusada", "Mai'Adua", "Malumfashi", 
                "Mani", "Mashi", "Matazu", "Musawa", "Rimi", 
                "Sabuwa", "Safana", "Sandamu", "Zango"
            ],
            "Kebbi": [
                "Aleiro", "Arewa Dandi", "Argungu", "Augie", "Bagudo", 
                "Birnin Kebbi", "Bunza", "Dandi", "Fakai", "Gwandu", 
                "Jega", "Kalgo", "Koko/Besse", "Maiyama", "Ngaski", 
                "Sakaba", "Shanga", "Suru", "Wasagu/Danko", "Yauri", "Zuru"
            ],
            "Kogi": [
                "Adavi", "Ajaokuta", "Ankpa", "Bassa", "Dekina", 
                "Ibaji", "Idah", "Igalamela Odolu", "Ijumu", "Kabba/Bunu", 
                "Kogi", "Lokoja", "Mopa-Muro", "Ofu", "Ogori/Magongo", 
                "Okehi", "Okene", "Olamaboro", "Omala", "Yagba East", "Yagba West"
            ],
            "Kwara": [
                "Asa", "Baruten", "Edu", "Ekiti", "Ifelodun", 
                "Ilorin East", "Ilorin South", "Ilorin West", "Irepodun", "Isin", 
                "Kaiama", "Moro", "Offa", "Oke Ero", "Oyun", "Pategi"
            ],
            "Lagos": [
                "Agege", "Ajeromi-Ifelodun", "Alimosho", "Amuwo-Odofin", "Apapa", 
                "Badagry", "Epe", "Eti-Osa", "Ibeju-Lekki", "Ifako-Ijaiye", 
                "Ikeja", "Ikorodu", "Kosofe", "Lagos Island", "Lagos Mainland", 
                "Mushin", "Ojo", "Oshodi-Isolo", "Shomolu", "Surulere"
            ],
            "Nasarawa": [
                "Akwanga", "Awe", "Doma", "Karu", "Keana", 
                "Keffi", "Kokona", "Lafia", "Nasarawa", "Nasarawa Eggon", 
                "Obi", "Toto", "Wamba"
            ],
            "Niger": [
                "Agaie", "Agwara", "Bida", "Borgu", "Bosso", 
                "Chanchaga", "Edati", "Gbako", "Gurara", "Katcha", 
                "Kontagora", "Lapai", "Lavun", "Magama", "Mariga", 
                "Mashegu", "Mokwa", "Moya", "Paikoro", "Rafi", 
                "Rijau", "Shiroro", "Suleja", "Tafa", "Wushishi"
            ],
            "Ogun": [
                "Abeokuta North", "Abeokuta South", "Ado-Odo/Ota", "Egbado North", "Egbado South", 
                "Ewekoro", "Ifo", "Ijebu East", "Ijebu North", "Ijebu North East", 
                "Ijebu Ode", "Ikenne", "Imeko Afon", "Ipokia", "Obafemi Owode", 
                "Odeda", "Odogbolu", "Ogun Waterside", "Remo North", "Shagamu"
            ],
            "Ondo": [
                "Akoko North-East", "Akoko North-West", "Akoko South-East", "Akoko South-West", "Akure North", 
                "Akure South", "Ese Odo", "Idanre", "Ifedore", "Ilaje", 
                "Ile Oluji/Okeigbo", "Irele", "Odigbo", "Okitipupa", "Ondo East", 
                "Ondo West", "Ose", "Owo"
            ],
            "Osun": [
    "Aiyedade", "Aiyedire", "Atakumosa East", "Atakumosa West", "Boluwaduro",
    "Boripe", "Ede North", "Ede South", "Egbedore", "Ejigbo",
    "Ife Central", "Ife East", "Ife North", "Ife South", "Ifedayo",
    "Ifelodun", "Ila", "Ilesa East", "Ilesa West", "Irepodun",
    "Irewole", "Isokan", "Iwo", "Obokun", "Odo Otin",
    "Ola Oluwa", "Olorunda", "Oriade", "Orolu", "Osogbo"
],

"Oyo": [
    "Afijio", "Akinyele", "Atiba", "Atisbo", "Egbeda",
    "Ibadan North", "Ibadan North-East", "Ibadan North-West", "Ibadan South-East", "Ibadan South-West",
    "Ibarapa Central", "Ibarapa East", "Ibarapa North", "Ido", "Irepo",
    "Iseyin", "Itesiwaju", "Iwajowa", "Kajola", "Lagelu",
    "Ogbomosho North", "Ogbomosho South", "Ogo Oluwa", "Olorunsogo", "Oluyole",
    "Ona Ara", "Orelope", "Ori Ire", "Oyo East", "Oyo West",
    "Saki East", "Saki West", "Surulere"
],

"Plateau": [
    "Barkin Ladi", "Bassa", "Bokkos", "Jos East", "Jos North",
    "Jos South", "Kanam", "Kanke", "Langtang North", "Langtang South",
    "Mangu", "Mikang", "Pankshin", "Qua'an Pan", "Riyom",
    "Shendam", "Wase"
],

"Rivers": [
    "Abua/Odual", "Ahoada East", "Ahoada West", "Akuku Toru", "Andoni",
    "Asari-Toru", "Bonny", "Degema", "Eleme", "Emohua",
    "Etche", "Gokana", "Ikwerre", "Khana", "Obio/Akpor",
    "Ogba/Egbema/Ndoni", "Ogu/Bolo", "Okrika", "Omuma", "Opobo/Nkoro",
    "Oyigbo", "Port Harcourt", "Tai"
],

"Sokoto": [
    "Binji", "Bodinga", "Dange Shuni", "Gada", "Goronyo",
    "Gudu", "Gwadabawa", "Illela", "Isa", "Kebbe",
    "Kware", "Rabah", "Sabon Birni", "Shagari", "Silame",
    "Sokoto North", "Sokoto South", "Tambuwal", "Tangaza", "Tureta",
    "Wamako", "Wurno", "Yabo"
],

"Taraba": [
    "Ardo Kola", "Bali", "Donga", "Gashaka", "Gassol",
    "Ibi", "Jalingo", "Karim Lamido", "Kumi", "Lau",
    "Sardauna", "Takum", "Ussa", "Wukari", "Yorro",
    "Zing"
],

"Yobe": [
    "Bade", "Bursari", "Damaturu", "Fika", "Fune",
    "Geidam", "Gujba", "Gulani", "Jakusko", "Karasuwa",
    "Machina", "Nagere", "Nguru", "Potiskum", "Tarmuwa",
    "Yunusari", "Yusufari"
],

"Zamfara": [
    "Anka", "Bakura", "Birnin Magaji/Kiyaw", "Bukkuyum", "Bungudu",
    "Chafe", "Gummi", "Gusau", "Kaura Namoda", "Maradun",
    "Maru", "Shinkafi", "Talata Mafara", "Zurmi"
],

            // Gombe to Zamfara continues here
        }
    }
};


        // Handle Country Change
        document.getElementById('country').addEventListener('change', function() {
            const selectedCountry = this.value;
            const stateContainer = document.getElementById('state-container');
            const cityContainer = document.getElementById('city-container');
            const stateSelect = document.getElementById('state');
            const citySelect = document.getElementById('city');

            // Reset State and City Select
            stateSelect.innerHTML = '<option value="" selected disabled>Select your state</option>';
            citySelect.innerHTML = '<option value="" selected disabled>Select your city</option>';

            if (selectedCountry && countries[selectedCountry]) {
                // Show State Dropdown
                stateContainer.style.display = 'block';
                cityContainer.style.display = 'none';

                // Populate States
                const states = countries[selectedCountry].states;
                for (const state in states) {
                    const option = document.createElement('option');
                    option.value = state;
                    option.textContent = state;
                    stateSelect.appendChild(option);
                }
            } else {
                stateContainer.style.display = 'none';
                cityContainer.style.display = 'none';
            }
        });

        // Handle State Change
        document.getElementById('state').addEventListener('change', function() {
            const selectedState = this.value;
            const selectedCountry = document.getElementById('country').value;
            const cityContainer = document.getElementById('city-container');
            const citySelect = document.getElementById('city');

            // Reset City Select
            citySelect.innerHTML = '<option value="" selected disabled>Select your city</option>';

            if (selectedCountry && selectedState && countries[selectedCountry]) {
                const cities = countries[selectedCountry].states[selectedState];
                cityContainer.style.display = 'block';

                // Populate Cities
                cities.forEach(function(city) {
                    const option = document.createElement('option');
                    option.value = city;
                    option.textContent = city;
                    citySelect.appendChild(option);
                });
            } else {
                cityContainer.style.display = 'none';
            }
        });
    </script>
</body>
</html>
<?php
include('include/footer.php');
?>
