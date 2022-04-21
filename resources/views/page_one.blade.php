<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Latihan Membuat Peta</title>
    
        <!-- leaflet css  -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
            integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
            crossorigin="" />
    
        <!-- bootstrap cdn  -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
            integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <style>
            /* ukuran peta */
            #mapid {
                height: 600px;
            }
        </style>
    </head>
    
    <body>
    
        <?php
            //inisialisai curl untuk digunakan
            $curl = curl_init();
            //set URL
            curl_setopt($curl, CURLOPT_URL, "https://data.covid19.go.id/public/api/prov.json");
            //kembalikan nilai menjadi string
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            //eksekusi curl dan masukan data ke dalam variabel output
            $output = curl_exec($curl);
    
            curl_close($curl);
    
            //simpan output ke dalam variabel data
            $data = json_decode($output, true);
        
        ?>
    
            <div class="container mt-5">
                <nav class="navbar navbar-light bg-light mb-4">
                    <span class="navbar-brand mb-0 h1"> Data Sebaran Corona Per Provinsi</span>
                </nav>
                <div id="mapid"></div>
            </div>
    
        <!-- leaflet js  -->
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
            integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
            crossorigin=""></script>
    
        <script>
            // set lokasi latitude dan longitude, lokasinya adalah Indonesia, 5 adalah besar peta
            var mymap = L.map('mapid').setView([-2.548926, 118.0148634], 5);   
            //setting maps menggunakan api mapbox bukan google maps, daftar dan dapatkan token      
            L.tileLayer(
                'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibmFiaWxjaGVuIiwiYSI6ImNrOWZzeXh5bzA1eTQzZGxpZTQ0cjIxZ2UifQ.1YMI-9pZhxALpQ_7x2MxHw', {
                    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                    maxZoom: 20,
                    id: 'mapbox/streets-v11', //menggunakan peta model streets-v11 kalian bisa melihat jenis-jenis peta lainnnya di web resmi mapbox
                    tileSize: 512,
                    zoomOffset: -1,
                    accessToken: 'your.mapbox.access.token'
                }).addTo(mymap);
    
            <?php foreach ($jsonData['list_data'] as $value) { ?>
                    L.marker([
                        <?php echo $value['lokasi']['lat']; ?>,
                        <?php echo $value['lokasi']['lon']; ?>
                    ]
                    ).addTo(mymap)
                    //data ditampilkan di dalam bindPopup( data ) dan dapat dikustomisasi dengan html
                    .bindPopup(`
                        <?php
                            echo '
                                <p>'.$value['key'].'</p>
                                <table style="width: 100%; font-size: 10px;" class="table table-borderless table-striped">
                                    <tr>
                                        <td>JUMLAH KASUS</td>
                                        <td>'.$value['jumlah_kasus'].'</td>
                                    </tr>
                                    <tr>
                                        <td>JUMLAH SEMBUH</td>
                                        <td>'.$value['jumlah_sembuh'].'</td>
                                    </tr>
                                    <tr>
                                        <td>JUMLAH MENINGGAL</td>
                                        <td>'.$value['jumlah_meninggal'].'</td>
                                    </tr>
                                    <tr>
                                        <td>JUMLAH DIRAWAT</td>
                                        <td>'.$value['jumlah_dirawat'].'</td>
                                    </tr>
                                </table>
                            ';   
                        ?>`
                    )
            <?php } ?>
        </script>
    </body>
    
</html>