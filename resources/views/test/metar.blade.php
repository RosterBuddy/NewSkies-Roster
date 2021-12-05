@extends('layouts.app')
@section('content')
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
</style>

<div class='square-container'>
<?php 

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.checkwx.com/metar/EKYT,EKAH,EGPD,GCRR,GMAD,LEMG,LIEA,LEAL,OJAI,EHAM,LIPY,OJAQ,ESSA,LGAV,LEBL,LIBR,EDDB,LFRB,LIME,EGBB,LFBZ,EKBI,LIPE,LQBK,LFBD,EGHH,EDDW,LIBD,LKTB,EGGD,EBBR,LFSB,LZIB,LHBP,LFOB,LFSL,EPBY,LFMU,LIEE,LFMK,LECH,LFLC,EDDK,LGSA,LIRA,LICB,LRCL,EKCH,EBCI,LIBC,LICC,LIMZ,EGFF,LFGJ,EDLW,EIDW,EGPH,LFBE,EHEH,EGNX,GMMI,EGTE,LPFR,LIRF,GMFF,EDSB,EDJA,LFTW,EDDF,GCFV,EPGD,EGPF,LIMJ,ESGG,LEGE,EDDH,EFHK,EDFH,UKHH,LEIB,LYNI,UKBB,EIKY,EPKK,LZKZ,EPKT,EYKA,EGNM,EPLL,LFBT,EGKK,LFBL,LFQQ,LPPT,GCLP,EGGP,EFLP,LFBH,EGGW,ELLX,EPLB,UKLL,LFLL,LEMD,LEMH,EGCC,LMML,EGNV,ESMS,LFML,EHBK,LIMC,LIRN,LFMN,EGNT,GMMW,EIKN,EGHQ,EDLV,LFRS,EDDN,UKOO,LROD,LPPR,EICK,ENGM,LKMT,LROP,GMFO,GMMZ,LPPD,LBPD,LIRZ,LCPH,LFMP,EGPK,LFBI,EYPA,LIMP,LEPA,LICJ,EPPO,LKPR,LIRP,LIBP,EGHL,GMMX,GMME,EVRA,LEMI,EPRZ,LRSB,LEST,LRSV,LEXJ,LGTS,EINN,LBSF,EGSS,LICA,LEZL,LOWS,EPSY,EPSC,LPLA,GCXO,GCTS,LYPG,EETN,LFBO,LLBG,EFTP,GMTT,LICT,ENTO,LIMF,LIPQ,LIPH,LRTR,GMTN,LFOT,LIPZ,LEVX,LOWW,LEVT,LEVC,LEVD,EYVI,LIPX,ESOW,EPMO,EPWR,LFOK,LEJR,LDZA,LEZG/decoded');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['X-API-Key: c7ec86f8437f41e9b1b5e68341']);

$resp = curl_exec($ch);
$results = json_decode($resp,true);
$metars = $results['data'];

foreach ($metars as $metar => $value) {
    if ($value['flight_category'] == "IFR" || $value['flight_category'] == "LIFR") {
        echo "
        <div class='square'"; 
        try{
          if($value['visibility']['meters_float'] < 2000) {
            echo 'style="background-color:red; color:white;"';
          }elseif($value['visibility']['meters_float'] <= 5000) {
            echo 'style="background-color:yellow;"';
          }
        } catch (Throwable $t){

        }
        echo ">
            <div class='content text-center'>
                {$value['icao']} 
                  <br> 
                <p style='max-width: 95%;'>{$value['raw_text']}</p>
            </div>
        </div>";
        // echo "<h1>". $value['icao'] . "</h1><p>" . $value['raw_text'] . "</p>";
    }
}


curl_close($ch);

?>
</div>

@endsection