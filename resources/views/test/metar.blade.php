@extends('layouts.app')
@section('content')
<?php 
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://api.checkwx.com/metar/EKYT,EKAH,EGPD,GCRR,GMAD,LEMG,LIEA,LEAL,OJAI,EHAM,LIPY,OJAQ,ESSA,LGAV,LEBL,LIBR,EDDB,LFRB,LIME,EGBB,LFBZ,EKBI,LIPE,LQBK,LFBD,EGHH,EDDW,LIBD,LKTB,EGGD,EBBR,LFSB,LZIB,LHBP,LFOB,LFSL,EPBY,LFMU,LIEE,LFMK,LECH,LFLC,EDDK,LGSA,LIRA,LICB,LRCL,EKCH,EBCI,LIBC,LICC,LIMZ,EGFF,LFGJ,EDLW,EIDW,EGPH,LFBE,EHEH,EGNX,GMMI,EGTE,LPFR,LIRF,GMFF,EDSB,EDJA,LFTW,EDDF,GCFV,EPGD,EGPF,LIMJ,ESGG,LEGE,EDDH,EFHK,EDFH,UKHH,LEIB,LYNI,UKBB,EIKY,EPKK,LZKZ,EPKT,EYKA,EGNM,EPLL,LFBT,EGKK,LFBL,LFQQ,LPPT,GCLP,EGGP,EFLP,LFBH,EGGW,ELLX,EPLB,UKLL,LFLL,LEMD,LEMH,EGCC,LMML,EGNV,ESMS,LFML,EHBK,LIMC,LIRN,LFMN,EGNT,GMMW,EIKN,EGHQ,EDLV,LFRS,EDDN,UKOO,LROD,LPPR,EICK,ENGM,LKMT,LROP,GMFO,GMMZ,LPPD,LBPD,LIRZ,LCPH,LFMP,EGPK,LFBI,EYPA,LIMP,LEPA,LICJ,EPPO,LKPR,LIRP,LIBP,EGHL,GMMX,GMME,EVRA,LEMI,EPRZ,LRSB,LEST,LRSV,LEXJ,LGTS,EINN,LBSF,EGSS,LICA,LEZL,LOWS,EPSY,EPSC,LPLA,GCXO,GCTS,LYPG,EETN,LFBO,LLBG,EFTP,GMTT,LICT,ENTO,LIMF,LIPQ,LIPH,LRTR,GMTN,LFOT,LIPZ,LEVX,LOWW,LEVT,LEVC,LEVD,EYVI,LIPX,ESOW,EPMO,EPWR,LFOK,LEJR,LDZA,LEZG/decoded');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_HTTPHEADER, ['X-API-Key: c7ec86f8437f41e9b1b5e68341']);

  $resp = curl_exec($ch);
  $results = json_decode($resp,true);
  $metars = $results['data'];
?>
<meta http-equiv="refresh" content="60">

{{-- https://api.checkwx.com/metar/EKYT,EKAH,EGPD,GCRR,GMAD,LEMG,LIEA,LEAL,OJAI,EHAM,LIPY,OJAQ,ESSA,LGAV,LEBL,LIBR,EDDB,LFRB,KBFI,LIME,EGBB,LFBZ,KBIS,EKBI,LIPE,LQBK,LFBD,EGHH,EDDW,LIBD,LKTB,EGGD,EBBR,LFSB,LZIB,KBTV,LHBP,LFOB,LFSL,EPBY,LFMU,LIEE,LFMK,LECH,LFLC,EDDK,LGSA,LIRA,LICB,LRCL,EKCH,EBCI,LIBC,LICC,LIMZ,KCWA,EGFF,LFGJ,EDLW,EIDW,KDVL,EGPH,LFBE,EHEH,EGNX,KERI,GMMI,EGTE,LPFR,KFAR,LIRF,GMFF,EDSB,EDJA,LFTW,EDDF,GCFV,EPGD,EGPF,LIMJ,ESGG,LEGE,EDDH,EFHK,EDFH,UKHH,LEIB,LYNI,UKBB,EIKY,EPKK,LZKZ,EPKT,EYKA,EGNM,EPLL,LFBT,EGKK,LFBL,LFQQ,LPPT,GCLP,EGGP,EFLP,LFBH,EGGW,ELLX,EPLB,UKLL,LFLL,LEMD,LEMH,EGCC,KMHT,KMKE,LMML,EGNV,ESMS,KMOT,LFML,EHBK,LIMC,LIRN,LFMN,EGNT,GMMW,EIKN,EGHQ,EDLV,LFRS,EDDN,UKOO,LROD,LPPR,EICK,ENGM,LKMT,LROP,GMFO,GMMZ,LPPD,LBPD,LIRZ,LCPH,LFMP,EGPK,LFBI,EYPA,LIMP,LEPA,LICJ,EPPO,KPQI,LKPR,LIRP,LIBP,KPWM,EGHL,GMMX,GMME,KRHI,EVRA,LEMI,EPRZ,KSBN,LRSB,LEST,LRSV,LEXJ,LGTS,EINN,LBSF,EGSS,LICA,LEZL,LOWS,EPSY,EPSC,LPLA,GCXO,GCTS,LYPG,EETN,LFBO,LLBG,EFTP,GMTT,LICT,ENTO,LIMF,LIPQ,LIPH,LRTR,GMTN,LFOT,KTVF,LIPZ,LEVX,LOWW,LEVT,LEVC,LEVD,EYVI,LIPX,ESOW,EPMO,EPWR,KWVL,LFOK,LEJR,KXWA,LDZA,LEZG/decoded --}}
<style>
.square-container {
  display: flex;
  flex-wrap: wrap;
}
.square {
  position: relative;
  flex-basis: calc(19.333% - 10px);
  margin-top: 50px;
  margin-right: 50px;
  margin-bottom: -30px;
  margin-left: 50px;
  border: 1px solid;
  box-sizing: border-box;
}

.square::before {
  content: '';
  display: block;
  padding-top: 30%;
}

.square .content {
  position: absolute;
  top: 0; left: 0;
  height: 100%;
  width: 100%;
}
.text-center {
    text-align: center;
}
body{
  background-color:#6e6e6e;
  color:white;
}
</style>
<div class="text-center">
  <h3>Visibility</h3>
  <div class='square-container'>
  <?php
  $style = "";
  foreach ($metars as $metar => $value) {
      if ($value['flight_category'] == "IFR" || $value['flight_category'] == "LIFR") {
        try {
          if($value['visibility']['meters_float'] <= 1000) {
            $style = "red";
          }elseif ($value['visibility']['meters_float'] <= 2000) {
            $style = "orange";
          }elseif ($value['visibility']['meters_float'] <= 5000) {
            $style = "green";
          }
          echo "<div class='square' style='background-color:".$style.";'>";
            echo "<div class='content text-center'>";
              echo $value['icao'];
              echo "<br>";
              try {
                echo "<p style='max-width: 95%;'>{$value['raw_text']}</p>";
              } catch (\Throwable $th) {
              }
            echo "</div>";
          echo "</div>";
        } catch (\Throwable $th) {
        }
      }
  }
  curl_close($ch);
  ?>
  </div>
</div>
<br>
<div style="padding-top:3%;" class="text-center">
  <h3>Wind</h3>
  <div class='square-container'>
    <?php 
    $style = "";
      foreach ($metars as $metar => $value) {
        try {
        if ($value['wind']['gust_kts'] >= 40) {
          $style = "red";
        }elseif ($value['wind']['gust_kts'] >= 35) {
          $style = "orange";
        }elseif ($value['wind']['gust_kts'] >= 20) {
          $style = "green";
        }
        if($value['wind']['gust_kts'] > 20 || $value['wind']['speed_kts'] > 15) {
          echo "<div class='square' style='background-color:".$style.";'>";
            echo "<div class='content text-center'>";
              echo $value['icao'];
              echo "<br>";
              try {
                echo "<p style='max-width: 95%;'>{$value['raw_text']}</p>";
              } catch (\Throwable $th) {
              }
            echo "</div>";
          echo "</div>";
        }
        } catch (\Throwable $th) {
          //throw $th;
        }
      }
    ?>
  </div>
</div>
{{-- <div class='square'>
  <div class='content text-center'>
      {$value['icao']} 
        <br> 
      <p style='max-width: 95%;'>{$value['wind']['gust_kts']}</p>
  </div>
</div> --}}
@endsection