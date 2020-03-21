<div class="doc">
  <h1>Serah Terima Berkas untuk Permohonan Registrasi</h1>
  <div class="nobreak">
    <table class="rowdata" cellpadding="0" cellspacing="0">
      <tr>
        <th>No</th>
        <th>Nama Pemohoan</th>
        <th>LPJK Prop</th>
        <th>USTK</th>
        <th>Asosiasi</th>
        <th>Kualifikasi</th>
        <th>Jenis Mohon</th>
        <th>Sub Klasifikasi</th>
        <th>Kode</th>
        <th>No KTP</th>
        <th>Catatan</th>
      </tr>
      @foreach($transaction as $i => $p)
        <tr>
          <td class="center">{{$i + 1}}</td>
          <td>{{$p->nama}}</td>
          <td>{{$p->provinsi->nama}}</td>
          <td>{{$p->ustk->nama}}</td>
          <td>{{$p->asosiasi->nama}}</td>
          <td>{{$p->tipe_sertifikat == "SKA" ? $p->kualifikasi->deskripsi_ahli : $p->kualifikasi->deskripsi_trampil}}</td>
          <td>{{$p->id_permohonan == "1" ? "Baru" : ($p->id_permohonan == "2" ? "Perpanjangan" : "Perubahan")}}</td>
          <td>{{$p->klasifikasi->deskripsi}}</td>
          <td>{{$p->id_sub_bidang}}</td>
          <td>{{$p->id_personal}}</td>
          <td></td>
        </tr>
      @endforeach
    </table>
  </div>

  <div class="ttd-box nobreak" style="width:300px">
    <h4>Asosiasi Ke USTKM (Setelah Status "99")</h4>
    <div class="ttd float" style="border-right:none">
      <span class="top">Dikirim Oleh</span>
      <span class="bottom">( Asosiasi )</span>
      {{-- <img style="max-width: 121px;max-height: 130px;" src="{{asset('image/signature/database/' . $ttd_database)}}" /> --}}
    </div>
    <div class="ttd float">
      <span class="top">Diterima Oleh</span>
      <span class="bottom">( USTKM Mandiri )</span>
      {{-- <img style="max-width: 121px;max-height: 130px;" src="{{asset('image/signature/verifikator/' . $ttd_verifikator)}}" /> --}}
    </div>
    <div class="clearfix"></div>
  </div>

  <div class="ttd-box nobreak" style="width:300px">
    <h4>USTKM Ke LPJK_P (Setelah Status "2")</h4>
    <div class="ttd float" style="border-right:none">
      <span class="top">Dikirim Oleh</span>
      <span class="bottom">( USTKM Mandiri )</span>
      {{-- <img style="max-width: 121px;max-height: 130px;" src="{{asset('image/signature/database/' . $ttd_database)}}" /> --}}
    </div>
    <div class="ttd float">
      <span class="top">Diterima Oleh</span>
      <span class="bottom">( LPJK_P )</span>
      {{-- <img style="max-width: 121px;max-height: 130px;" src="{{asset('image/signature/verifikator/' . $ttd_verifikator)}}" /> --}}
    </div>
    <div class="clearfix"></div>
  </div>

  <div class="ttd-box nobreak" style="width:300px">
    <h4>LPJK_P Ke USTKM (Setelah Status "4")</h4>
    <div class="ttd float" style="border-right:none">
      <span class="top">Dikirim Oleh</span>
      <span class="bottom">( LPJK_P )</span>
      {{-- <img style="max-width: 121px;max-height: 130px;" src="{{asset('image/signature/database/' . $ttd_database)}}" /> --}}
    </div>
    <div class="ttd float">
      <span class="top">Diterima Oleh</span>
      <span class="bottom">( USTKM Mandiri )</span>
      {{-- <img style="max-width: 121px;max-height: 130px;" src="{{asset('image/signature/verifikator/' . $ttd_verifikator)}}" /> --}}
    </div>
    <div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
</div>

<div class="doc">
  <h1>Daftar Registrasi Tenaga Kerja Konstruksi</h1>
  <div class="nobreak">
    <table class="rowdata" cellpadding="0" cellspacing="0">
      <tr>
        <th>No</th>
        <th>Nama Pemohoan</th>
        <th>Alamat</th>
        <th>No KTP</th>
        <th>Jenjan_P</th>
        <th>Prgm. Study</th>
        <th>Kode</th>
        <th>Kualifikasi</th>
        <th>Asosiasi</th>
        <th>Permohonan</th>
      </tr>
      @foreach($transaction as $i => $p)
        <tr>
          <td class="center">{{$i + 1}}</td>
          <td>{{$p->nama}}</td>
          <td>{{$p->personal ? $p->personal->Alamat1 : ""}}</td>
          <td>{{$p->id_personal}}</td>
          <td></td>
          <td></td>
          <td>{{$p->id_sub_bidang}}</td>
          <td>{{$p->tipe_sertifikat == "SKA" ? $p->kualifikasi->deskripsi_ahli : $p->kualifikasi->deskripsi_trampil}}</td>
          <td>{{$p->asosiasi->nama}}</td>
          <td>{{$p->id_permohonan == "1" ? "Baru" : ($p->id_permohonan == "2" ? "Perpanjangan" : "Perubahan")}}</td>
        </tr>
      @endforeach
    </table>
  </div>

  <div class="ttd-box nobreak">
    <h4>Diajukan Oleh:</h4>
    <div class="ttd noborder">
      <span class="bottom">( Ir. H. ROY MEINDO )</span>
      {{-- <img style="max-width: 121px;max-height: 130px;" src="{{asset('image/signature/database/' . $ttd_database)}}" /> --}}
    </div>
  </div>

  <div class="ttd-box nobreak">
    <h4>Menyetujui:</h4>
    <div class="ttd noborder">
      <span class="bottom">Pengurus LPJK_P RIAU</span>
      {{-- <img style="max-width: 121px;max-height: 130px;" src="{{asset('image/signature/database/' . $ttd_database)}}" /> --}}
    </div>
  </div>
    <div class="clearfix"></div>
  </div>

  <div class="clearfix"></div>
</div>

<div class="doc">
  <h1>Daftar Tenaga {{$transaction[0]->tipe_sertifikat == "SKA" ? "Ahli" : "Trampil"}} Konstruksi</h1>
  <div class="nobreak">
    <table class="rowdata" cellpadding="0" cellspacing="0">
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>No KTP</th>
        <th>No NPWP</th>
        <th>Jenis Sertifikat</th>
        <th>Sub Klasifikasi</th>
        <th>Kode</th>
        <th>Kualifikasi</th>
        <th>Asosiasi</th>
        <th>Permohonan</th>
      </tr>
      @foreach($transaction as $i => $p)
        <tr>
          <td class="center">{{$i + 1}}</td>
          <td>{{$p->nama}}</td>
          <td>{{$p->id_personal}}</td>
          <td>{{$p->personal ? $p->personal->npwp : ""}}</td>
          <td>{{$p->tipe_sertifikat}}</td>
          <td>{{$p->klasifikasi->deskripsi}}</td>
          <td>{{$p->id_sub_bidang}}</td>
          <td>{{$p->tipe_sertifikat == "SKA" ? $p->kualifikasi->deskripsi_ahli : $p->kualifikasi->deskripsi_trampil}}</td>
          <td>{{$p->asosiasi->nama}}</td>
          <td>{{$p->id_permohonan == "1" ? "Baru" : ($p->id_permohonan == "2" ? "Perpanjangan" : "Perubahan")}}</td>
        </tr>
      @endforeach
    </table>
  </div>

  <div class="ttd-box nobreak">
    <h4>Diajukan Oleh:</h4>
    <div class="ttd noborder">
      <span class="bottom">( Ir. H. ROY MEINDO )</span>
      {{-- <img style="max-width: 121px;max-height: 130px;" src="{{asset('image/signature/database/' . $ttd_database)}}" /> --}}
    </div>
  </div>
</div>

<style>
  .doc {
    page-break-after: always;
  }
  @media print {
    .landscape {
      -webkit-transform: rotate(90deg);
      -moz-transform: rotate(90deg);
      -o-transform: rotate(90deg);
      -ms-transform: rotate(90deg);
      transform: rotate(90deg);
    }
  }
  body {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
  }
  h1 {
    margin-top: 60px;
    font-size: 18px;
    font-weight: normal;
  }
  h2 {
    font-size: 14px;
    font-weight: normal;
    text-align: center;
  }
  h4 {
    font-size: 12px;
    font-weight: normal;
    margin-top: 40px;
    margin-bottom: 2px;
  }
  .center {
    text-align: center;
  }
  .nobreak {
    page-break-inside: avoid;
  }
  table {
    font-size: 12px;
    page-break-inside: avoid;
  }
  table.rowdata {
    width: 100%;
  }
  th {
    padding: 4px;
    font-weight: normal;
  }
  td {
    padding: 4px;
  }
  .rowdata th, .rowdata td {
    border: 1px solid #000;
    border-right: none;
    border-bottom: none;
  }
  .rowdata th:last-child, .rowdata td:last-child {
    border-right: 1px solid #000;
  }
  .rowdata tr:last-child td {
    border-bottom: 1px solid #000;
  }
  .logo {
    width: 90px;
    float: left;
    margin-top: -52px;
    margin-right: 20px;
    margin-bottom: 50px;
  }
  .clearfix {
      clear: both;
  }
  .ttd-box {
    width: 180px;
    margin-right: 20px;
    text-align: center;
    float: left;
  }

  .ttd {
      height: 130px;
      border: solid 1px;
      position: relative;
  }
  .ttd.noborder {
    border: none;
  }

  .ttd span {
      position: absolute;
      bottom: 3px;
      left: 0;
      right: 0;
  }
  .ttd span.top {
    top: 4;
    bottom: auto;
  }
  .ttd.float {
    float: left;
    width: 48%;
  }
</style>