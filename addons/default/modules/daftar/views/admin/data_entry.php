<style type="text/css">
  table caption {
    background-color: aliceblue !important;
    font-size: 20px;
  }
  .entry-label:after {
    position: absolute;
    content: ":";
    float: right;
    right: 0px;
  }
  .entry-label {
    font-size: 18px;
    font-weight: bold;
    width: 200px;
    /* text-align: right; */
    clear: none;
    float: left;
    margin-right: 10px;
    position: relative;
    margin-left: 5px;
  }
  .entry-value {
    font-size: 18px;
  }
  .btn-group.content-toolbar {
    float: right;
    margin-right: 10px;
  }
  .page-header {
    border-bottom: 1px solid rgba(0,0,0,0.4);
    float: left;
    width: 100%;
    display: block;
  }
  .page-header>h1 {
    float: left;
    margin-top: 0px;
    margin-bottom: 5px;
  }
  .one_half>table {
    margin-bottom: 10px;
  }
  .one_half>table tbody tr th {
    background-color: #f9f9f9;
    border-top: 1px solid #ddd;
  }
  .one_half>table tbody tr:nth-child(even) th, .one_half>table tbody tr:hover th {
    background-color: #f5f5f5;
  }
  .one_half>table thead tr th {
    line-height: 1.4em;
  }
  .info {
    font-size: 11px;
  }
  @media print{
    header, footer, .btn {
      display: none;
    }
    div#container, section#content, .content-body {
      width: 98% !important;
    }
    section#content {
      margin-top: 0px !important;
    }
    div#container {
      margin: 1% 20px;
    }
    .one_half {
      float: left;
      width: 48%;
      margin-right: 10px;
    }
    .one_full {
      float: left;
      width: 100%;
    }
    .entry-label:after {
      position: absolute;
      content: ":";
      float: right;
      right: 0px;
    }
    .entry-label {
      font-size: 18px;
      font-weight: bold;
      width: 200px;
      /* text-align: right; */
      clear: none;
      float: left;
      margin-right: 10px;
      position: relative;
      margin-left: 5px;
    }
    .entry-value {
      font-size: 18px;
    }
    .info {
      font-size: 11px;
    }
    table tr.alt, table thead tr {
      background: #f5f5f5 !important;
    }
  }
</style>
<div class="page-header">
  <h1><?php echo lang('daftar:data:view'); ?></h1>

  <div class="btn-group content-toolbar">

    <a href="javascript:PrintElem();" class="btn blue">
      <i class="fa fa-print"></i> Print
    </a>

    <a href="<?php echo site_url('admin/daftar/data/index'); ?>" class="btn blue">
      <i class="fa fa-chevron-left"></i>
      <?php echo lang('daftar:back') ?>
    </a>

    <?php if(group_has_role('daftar', 'edit_all_data')){ ?>
      <a href="<?php echo site_url('admin/daftar/data/edit/'.$data['id']); ?>" class="btn green">
        <i class="fa fa-pencil"></i>
        <?php echo lang('global:edit') ?>
      </a>
    <?php }elseif(group_has_role('daftar', 'edit_own_data')){ ?>
      <?php if($data->created_by_user_id == $this->current_user->id){ ?>
        <a href="<?php echo site_url('admin/daftar/data/edit/'.$data->id); ?>" class="btn green">
          <i class="fa fa-pencil"></i>
          <?php echo lang('global:edit') ?>
        </a>
      <?php } ?>
    <?php } ?>

    <?php if(group_has_role('daftar', 'delete_all_data')){ ?>
      <a href="<?php echo site_url('admin/daftar/data/delete/'.$data['id']); ?>" class="confirm btn red">
        <i class="fa fa-trash-o"></i>
        <?php echo lang('global:delete') ?>
      </a>
    <?php }elseif(group_has_role('daftar', 'delete_own_data')){ ?>
      <?php if($data->created_by_user_id == $this->current_user->id){ ?>
        <a href="<?php echo site_url('admin/daftar/data/delete/'.$data['id']); ?>" class="confirm btn red">
          <i class="fa fa-trash-o"></i>
          <?php echo lang('global:delete') ?>
        </a>
      <?php } ?>
    <?php } ?>

  </div>
</div>

<div id="print">
  <div class="row">
    <div class="entry-label"><?php echo lang('daftar:nama'); ?></div>
    <?php if(isset($data['nama'])){ ?>
    <div class="entry-value"><?php echo $data['nama']; ?></div>
    <?php }else{ ?>
    <div class="entry-value">-</div>
    <?php } ?>
  </div>

  <div class="row">
    <div class="entry-label"><?php echo lang('daftar:status'); ?></div>
    <?php if(isset($data['status'])){ ?>
    <div class="entry-value"><?php echo $status[$data['status']]; ?></div>
    <?php }else{ ?>
    <div class="entry-value">-</div>
    <?php } ?>
  </div>

  <div class="row">
    <div class="entry-label"><?php echo (isset($data['updated_on'])) ? lang('daftar:updated') : lang('daftar:created'); ?></div>
    <div class="entry-value"><?php echo (isset($data['updated_on'])) ? format_date($data['updated_on'], 'd-m-Y G:i') : format_date($data['created_on'], 'd-m-Y G:i'); ?></div>
  </div>

  <div class="row">
    <?php
      $forms = json_decode($data['form'], TRUE);
      if($forms['pemilik']=='perorangan'){
    ?>
    <div class="one_half">
      <table>
        <caption><h2>Data Calon Pemilik Polis (Perorangan)</h2></caption>
        <tbody>
          <?php
          foreach ($forms['calono'] as $key => $value) {
          ?>
            <tr>
              <th width="140"><?php echo lang('calono:'.$key); ?></th>
              <th width="10">:</th>
              <td><?php echo ($value!='') ? $value : '-' ; ?></td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
    <?php }else{ ?>
    <div class="one_half">
      <table>
        <caption><h2>Data Calon Pemilik Polis (Perusahaan)</h2></caption>
        <tbody>
          <?php
          foreach ($forms['calonp'] as $key => $value) {
          ?>
            <tr>
              <th width="200"><?php echo lang('calonp:'.$key); ?></th>
              <th width="10">:</th>
              <td><?php echo ($value!='') ? $value : '-' ; ?></td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
    <?php } ?>

    <?php if(isset($forms['tanggung'])){ ?>
    <div class="one_half">
      <table>
        <caption><h2>Data Calon Tertanggung</h2></caption>
        <tbody>
          <?php
          foreach ($forms['tertanggung'] as $key => $value) {
          ?>
            <tr>
              <th width="140"><?php echo lang('calono:'.$key); ?></th>
              <th width="10">:</th>
              <td><?php echo ($value!='') ? $value : '-' ; ?></td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
    <?php } ?>

    <div class="one_half">
      <table width="100%">
        <caption><h2>Penerima Manfaat</h2></caption>
        <thead>
          <tr>
            <th>Nama Lengkap<br/>(Sesuai KTP)</th>
            <th>Jenis Kelamin</th>
            <th>Tempat,<br/>Tanggal Lahir</th>
            <th>Hubungan dgn Tertanggung</th>
            <th>%</th>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach($forms['pertanggungan']['nama'] as $key => $value){
              if($value!=''){
          ?>
          <tr>
            <td><?php echo $value; ?></td>
            <td><?php echo $forms['pertanggungan']['jenis_kelamin'][$key] ;?></td>
            <td><?php echo $forms['pertanggungan']['ttl'][$key] ;?></td>
            <td><?php echo $forms['pertanggungan']['hubungan'][$key] ;?></td>
            <td><?php echo $forms['pertanggungan']['persen'][$key] ;?>%</td>
          </tr>
          <?php
              }
            }
          ?>
        </tbody>
      </table>
    </div>

    <?php
      if(isset($forms['tanggung'])){
    ?>
    <div class="one_half">
      <table width="100%">
        <caption><h2>Riwayat Keluarga Calon Tertanggung</h2></caption>
        <thead>
          <tr>
            <th>Hubungan</th>
            <th>Status</th>
            <th>Umur</th>
            <th>Keadaan / Sebab</th>
          </tr>
        </thead>
        <?php
        foreach ( $forms['riwayat']['tertanggung'] as $key => $value) {
          $$key = $value;
        }
        ?>
        <tbody>
          <?php foreach ($arr_key as $key => $value) { ?>
          <tr>
            <th><?php echo $value; ?></th>
            <?php if((${$key}['meninggal']['umum']!='')&&(${$key}['hidup']['umur']!='')){ ?>
            <td><?php echo (${$key}['meninggal']['umum']!='') ? 'Meninggal' : 'Hidup' ; ?></td>
            <td><?php echo (${$key}['meninggal']['umum']!='') ? ${$key}['meninggal']['umum'] : ${$key}['hidup']['umur'] ; ?></td>
            <td><?php echo (${$key}['meninggal']['umum']!='') ? ${$key}['meninggal']['sebab'] : ${$key}['hidup']['keadaan'] ; ?></td>
            <?php }else{ ?>
              <td style="text-align:center;" colspan="3">Tidak ada data</td>
            <?php } ?>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <?php } ?>

    <div class="one_half">
      <table width="100%">
        <caption><h2>Riwayat Keluarga Calon Pemilik Polis</h2></caption>
        <thead>
          <tr>
            <th>Hubungan</th>
            <th>Status</th>
            <th>Umur</th>
            <th>Keadaan / Sebab</th>
          </tr>
        </thead>
        <?php
        foreach ( $forms['riwayat']['polis'] as $key => $value) {
          $$key = $value;
        }
        ?>
        <tbody>
          <?php foreach ($arr_key as $key => $value) { ?>
          <tr>
            <th><?php echo $value; ?></th>
            <?php if((${$key}['meninggal']['umum']!='')&&(${$key}['hidup']['umur']!='')){ ?>
            <td><?php echo (${$key}['meninggal']['umum']!='') ? 'Meninggal' : 'Hidup' ; ?></td>
            <td><?php echo (${$key}['meninggal']['umum']!='') ? ${$key}['meninggal']['umum'] : ${$key}['hidup']['umur'] ; ?></td>
            <td><?php echo (${$key}['meninggal']['umum']!='') ? ${$key}['meninggal']['sebab'] : ${$key}['hidup']['keadaan'] ; ?></td>
            <?php }else{ ?>
              <td style="text-align:center;" colspan="3">Tidak ada data</td>
            <?php } ?>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <div class="one_half">
      <table width="100%">
        <caption><h2>Jumlah Orang yang ditanggung secara finansial oleh calon pemilik polis</h2></caption>
        <thead>
          <tr>
            <th>Nama Lengkap<br/>(Sesuai KTP)</th>
            <th>Jenis Kelamin</th>
            <th>Tempat,<br/>Tanggal Lahir</th>
            <th>Hubungan dgn Tertanggung</th>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach($forms['finansial']['nama'] as $key => $value){
              if($value!=''){
          ?>
          <tr>
            <td><?php echo $value; ?></td>
            <td><?php echo $forms['finansial']['jenis_kelamin'][$key] ;?></td>
            <td><?php echo $forms['finansial']['ttl'][$key] ;?></td>
            <td><?php echo $forms['finansial']['hubungan'][$key] ;?></td>
          </tr>
          <?php
              }
            }
          ?>
        </tbody>
      </table>
    </div>

    <div class="one_full">
      <table width="100%">
        <caption><h2>Data Kesehatan Bagi <?php echo (isset($forms['tanggung'])) ? 'Tertanggung dan' : '' ;?> Pemegang Polis</h2></caption>
        <thead>
          <tr>
            <th style="width: 50%">Pertanyaan</th>
            <?php if(isset($forms['tanggung'])){ ?>
            <th>Tertanggung</th>
            <?php } ?>
            <th>Pemegang Polis</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Telah mempunyai polis di PT. Sun Life Finc. Ind, atau pada perusahaan asuransi lainnya ?</td>
            <?php if(isset($forms['tanggung'])){ ?>
            <td><?php echo ($forms['kesehatan']['tertanggung'][1]=='tidak') ? 'Tidak' : 'Nama Asuransi '.$forms['kesehatan']['tertanggung'][1] ;?></td>
            <?php } ?>
            <td><?php echo ($forms['kesehatan']['polis'][1]=='tidak') ? 'Tidak' : 'Nama Asuransi '.$forms['kesehatan']['polis'][1] ;?></td>
          </tr>
          <tr>
            <td>
              Pernah mengalami perubahan berat badan secara drastis dalam 1 tahun terakhir ?<br/>
            </td>
            <?php if(isset($forms['tanggung'])){ ?>
            <td><?php echo ($forms['kesehatan']['tertanggung'][2]=='tidak') ? 'Tidak' : 'Naik/Turun '.$forms['kesehatan']['tertanggung'][2].'kg' ;?></td>
            <?php } ?>
            <td><?php echo ($forms['kesehatan']['polis'][2]=='tidak') ? 'Tidak' : 'Naik/Turun '.$forms['kesehatan']['polis'][2].'kg' ;?></td>
          </tr>
          <tr>
            <td>
              Mengkonsumsi BIR, Anggur / minuman beralkohol lainnya  ?<br/>
              Pernah mendapatkan saran dari dokter untuk berhenti ?<br/>
              Perokok / mengkonsumsi jenis tembakau lainnya ?
            </td>
            <?php if(isset($forms['tanggung'])){ ?>
            <td>
              <?php
                if(isset($forms['kesehatan']['tertanggung'][3]['tidak'])){
                  echo "Tidak";
                }else{
                  if($forms['kesehatan']['tertanggung'][3]['jenis']!=''){
                    echo "Jenis Minuman ".$forms['kesehatan']['tertanggung'][3]['jenis']."<br/>";
                  }
                  if($forms['kesehatan']['tertanggung'][3]['botol']!=''){
                    echo $forms['kesehatan']['tertanggung'][3]['botol']." Botol / Minggu<br/>";
                  }
                  if($forms['kesehatan']['tertanggung'][3]['batang']!=''){
                    echo $forms['kesehatan']['tertanggung'][3]['batang']." Batang / Hari";
                  }
                }
              ?>
            </td>
            <?php } ?>
            <td>
              <?php
                if(isset($forms['kesehatan']['polis'][3]['tidak'])){
                  echo "Tidak";
                }else{
                  if($forms['kesehatan']['polis'][3]['jenis']!=''){
                    echo "Jenis Minuman ".$forms['kesehatan']['polis'][3]['jenis']."<br/>";
                  }
                  if($forms['kesehatan']['polis'][3]['botol']!=''){
                    echo $forms['kesehatan']['polis'][3]['botol']." Botol / Minggu<br/>";
                  }
                  if($forms['kesehatan']['polis'][3]['batang']!=''){
                    echo $forms['kesehatan']['polis'][3]['batang']." Batang / Hari";
                  }
                }
              ?>
            </td>
          </tr>
          <tr>
            <td>
              Khusus anak, proses kelahiran ?<br/>
            </td>
            <?php if(isset($forms['tanggung'])){ ?>
            <td>
              <?php
                if($forms['kesehatan']['tertanggung'][4]=='tidak'){
                  echo "Tidak";
                }else{
                  if($forms['kesehatan']['tertanggung'][4]['panjang']!=''){
                    echo "Panjang Bayi ".$forms['kesehatan']['tertanggung'][4]['panjang']."cm<br/>";
                  }
                  if($forms['kesehatan']['tertanggung'][4]['berat']!=''){
                    echo "Berat Bayi ".$forms['kesehatan']['tertanggung'][4]['berat']."kg<br/>";
                  }
                  if($forms['kesehatan']['tertanggung'][4]['kondisi']!=''){
                    echo "Kondisi Bayi ".$forms['kesehatan']['tertanggung'][4]['kondisi'];
                  }
                }
              ?>
            </td>
            <?php } ?>
            <td>
              <?php
                if($forms['kesehatan']['polis'][4]=='tidak'){
                  echo "Tidak";
                }else{
                  if($forms['kesehatan']['polis'][4]['panjang']!=''){
                    echo "Panjang Bayi ".$forms['kesehatan']['polis'][4]['panjang']."cm<br/>";
                  }
                  if($forms['kesehatan']['polis'][4]['berat']!=''){
                    echo "Berat Bayi ".$forms['kesehatan']['polis'][4]['berat']."kg<br/>";
                  }
                  if($forms['kesehatan']['polis'][4]['kondisi']!=''){
                    echo "Kondisi Bayi ".$forms['kesehatan']['polis'][4]['kondisi'];
                  }
                }
              ?>
            </td>
          </tr>
          <tr>
            <td>Mempunyai hobby dibidang penerbangan, menyelam, olahraga (aktivitas) yang mengandung bahaya ?</td>
            <?php if(isset($forms['tanggung'])){ ?>
            <td><?php echo ($forms['kesehatan']['tertanggung'][5]=='tidak') ? 'Tidak' : 'Nama Kegiatan '.$forms['kesehatan']['tertanggung'][5] ;?></td>
            <?php } ?>
            <td><?php echo ($forms['kesehatan']['polis'][5]=='tidak') ? 'Tidak' : 'Nama Kegiatan '.$forms['kesehatan']['polis'][5] ;?></td>
          </tr>
          <tr>
            <td>
              Dalam 5 Tahun ini :<br/>
              Menjalani pemeriksaan electrodiagram, darah, rontgent, treadmill atau pemeriksaan lainnya ?<br/>
              Mengalami infeksi saluran kencing / penyakit yang ditularkan melalui hubungan kelamin
            </td>
            <?php if(isset($forms['tanggung'])){ ?>
            <td><?php echo ($forms['kesehatan']['tertanggung'][6]=='tidak') ? 'Tidak' : $forms['kesehatan']['tertanggung'][6] ;?></td>
            <?php } ?>
            <td><?php echo ($forms['kesehatan']['polis'][6]=='tidak') ? 'Tidak' : $forms['kesehatan']['polis'][6] ;?></td>
          </tr>
          <tr>
            <td>
              Pernah menderita / mendapat pengobatan / meminta nasehat untuk :<br/>
              Nyeri dada, tekanan darah tinggi, kelainan paru-paru, kencing manis/ada gula dalam urine, sakit maag, colitis, diare kronis, hepatitis/kelainan hati/pencernaan lainnya, pingsan, ayan, kelainan syaraf dan mental.<br/>
              Kanker, tumor, pembesaran kelenjar, pembesaran kelenjar getah bening, anemia, pendarahan / kelainan darah, kelainan urine, ginjal/kantung kemih, arthritis, AIDS/ARC (AIDS Related Complex).<br/>
              Tes lainnya yang menunjukkan adanya HIV, penyakit-penyakit operasi/cidera lainnya?
            </td>
            <?php if(isset($forms['tanggung'])){ ?>
            <td><?php echo ($forms['kesehatan']['tertanggung'][7]=='tidak') ? 'Tidak' : $forms['kesehatan']['tertanggung'][7] ;?></td>
            <?php } ?>
            <td><?php echo ($forms['kesehatan']['polis'][7]=='tidak') ? 'Tidak' : $forms['kesehatan']['polis'][7] ;?></td>
          </tr>
          <tr>
            <td>
              Mempunyai gejala-gejala penyakit/keluhan kesehatan lainnya yang belum pernah dikonsultasikan ke dokter/diobati (demam dalam waktu lama, kehilangan berat badan yang tidak diketahui sebabnya, dll ?)
            </td>
            <?php if(isset($forms['tanggung'])){ ?>
            <td><?php echo ($forms['kesehatan']['tertanggung'][8]=='tidak') ? 'Tidak' : $forms['kesehatan']['tertanggung'][8] ;?></td>
            <?php } ?>
            <td><?php echo ($forms['kesehatan']['polis'][8]=='tidak') ? 'Tidak' : $forms['kesehatan']['polis'][8] ;?></td>
          </tr>
          <tr>
            <td>
              Saat ini menjalani perawatan diet dengan menggunakan obat-obatan / cara lainnya ?
            </td>
            <?php if(isset($forms['tanggung'])){ ?>
            <td><?php echo ($forms['kesehatan']['tertanggung'][9]=='tidak') ? 'Tidak' : $forms['kesehatan']['tertanggung'][9] ;?></td>
            <?php } ?>
            <td><?php echo ($forms['kesehatan']['polis'][9]=='tidak') ? 'Tidak' : $forms['kesehatan']['polis'][9] ;?></td>
          </tr>
          <tr>
            <td>
              Pernah menggunakan kokain, marijuana, LSD, amphetamine, heroin / narkotika lainnya ?
            </td>
            <?php if(isset($forms['tanggung'])){ ?>
            <td><?php echo ($forms['kesehatan']['tertanggung'][10]=='tidak') ? 'Tidak' : $forms['kesehatan']['tertanggung'][10] ;?></td>
            <?php } ?>
            <td><?php echo ($forms['kesehatan']['polis'][10]=='tidak') ? 'Tidak' : $forms['kesehatan']['polis'][10] ;?></td>
          </tr>
          <tr>
            <td>
              Khusus wanita :<br/>
              Sedang hamil?<br/>
              Mengalami kesulitan / komplikasi saat melahirkan ?
            </td>
            <?php if(isset($forms['tanggung'])){ ?>
            <td>
              <?php
                if($forms['kesehatan']['tertanggung'][11]=='tidak'){
                  echo "Tidak";
                }else{
                  if($forms['kesehatan']['tertanggung'][11]['umur_hamil']!=''){
                    echo "".$forms['kesehatan']['tertanggung'][11]['umur_hamil']." Bulan<br/>";
                  }
                  if($forms['kesehatan']['tertanggung'][11]['nama_dokter']!=''){
                    echo "Nama Dokter : ".$forms['kesehatan']['tertanggung'][11]['nama_dokter']."<br/>";
                  }
                  if($forms['kesehatan']['tertanggung'][11]['alamat_dokter']!=''){
                    echo "Alamat Dokter : ".$forms['kesehatan']['tertanggung'][11]['alamat_dokter'];
                  }
                }
              ?>
            </td>
            <?php } ?>
            <td>
              <?php
                if($forms['kesehatan']['polis'][11]=='tidak'){
                  echo "Tidak";
                }else{
                  if($forms['kesehatan']['polis'][11]['umur_hamil']!=''){
                    echo "".$forms['kesehatan']['polis'][11]['umur_hamil']." Bulan<br/>";
                  }
                  if($forms['kesehatan']['polis'][11]['nama_dokter']!=''){
                    echo "Nama Dokter : ".$forms['kesehatan']['polis'][11]['nama_dokter']."<br/>";
                  }
                  if($forms['kesehatan']['polis'][11]['alamat_dokter']!=''){
                    echo "Alamat Dokter : ".$forms['kesehatan']['polis'][11]['alamat_dokter'];
                  }
                }
              ?>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="one_half">
      <table width="100%">
        <caption><h2>Apabila terdapat pengembalian premi pertama, mohon ditransfer ke Rekening :</h2></caption>
        <tbody>
          <tr>
            <th width="160px">Nama Pemilik Rekening *</th>
            <th width="10px">:</th>
            <td><?php echo $forms['tambahan']['rekening']['nama']; ?></td>
          </tr>
          <tr>
            <th>Nomor Rekening</th>
            <th>:</th>
            <td><?php echo $forms['tambahan']['rekening']['nomor']; ?></td>
          </tr>
          <tr>
            <th>Nama Bank</th>
            <th>:</th>
            <td><?php echo $forms['tambahan']['rekening']['bank']; ?></td>
          </tr>
          <tr>
            <th>Cabang / Kota</th>
            <th>:</th>
            <td><?php echo $forms['tambahan']['rekening']['cabang']; ?></td>
          </tr>
          <tr>
            <td colspan="3" class="info">*) Rekening bank atas nama pemilik polis<br/>Jika pembayaran premi pertama menggunakan kartu kredit, maka pengembalian akan dikembalikan melalaui kartu kredit yang sama.</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="one_half">
      <table width="100%">
        <caption><h2>Identitas Pihak Ketiga</h2></caption>
        <tbody>
          <tr>
            <th width="150">Nama Pihak Ketiga *</th>
            <th width="10">:</th>
            <td colspan="4"><?php echo $forms['tambahan']['pihak_ketiga']['nama'];?></td>
          </tr>
          <tr>
            <th>Alamat</th>
            <th>:</th>
            <td colspan="4"><?php echo $forms['tambahan']['pihak_ketiga']['alamat'];?></td>
          </tr>
          <tr>
            <th>Tempat, Tanggal Lahir</th>
            <th>:</th>
            <td colspan="4"><?php echo $forms['tambahan']['pihak_ketiga']['lahir'];?></td>
          </tr>
          <tr>
            <th>Bidang Usaha</th>
            <th>:</th>
            <td colspan="4"><?php echo $forms['tambahan']['pihak_ketiga']['bidang_usaha'];?></td>
          </tr>
          <tr>
            <th>Telp Rumah/Kantor/HP/Fax</th>
            <th>:</th>
            <td><?php echo $forms['tambahan']['pihak_ketiga']['Rumah'];?></td>
            <td><?php echo $forms['tambahan']['pihak_ketiga']['Kantor'];?></td>
            <td><?php echo $forms['tambahan']['pihak_ketiga']['HP'];?></td>
            <td><?php echo $forms['tambahan']['pihak_ketiga']['Fax'];?></td>
          </tr>
          <tr class="perusahaan">
            <th>Tanggal Pendirian</th>
            <th>:</th>
            <td colspan="4"><?php echo $forms['tambahan']['pihak_ketiga']['Tanggal_Pendirian'];?></td>
          </tr>
          <tr class="perusahaan">
            <th>Tempat Kedudukan</th>
            <th>:</th>
            <td colspan="4"><?php echo $forms['tambahan']['pihak_ketiga']['Tempat_Kedudukan'];?></td>
          </tr>
          <tr>
            <th>Hubungan dengan Pemilik Polis</th>
            <th>:</th>
            <td colspan="4"><?php echo $forms['tambahan']['pihak_ketiga']['hubungan'];?></td>
          </tr>
          <tr>
            <th>Sumber Dana</th>
            <th>:</th>
            <td colspan="4"><?php echo $forms['tambahan']['pihak_ketiga']['sumber_dana'];?></td>
          </tr>
          <tr>
            <th>Tujuan Penggunaan Dana</th>
            <th>:</th>
            <td colspan="4"><?php echo $forms['tambahan']['pihak_ketiga']['tujuan_penggunaan'];?></td>
          </tr>
          <tr>
            <td colspan="7" class="info">*) </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script type="text/javascript">
    function PrintElem()
    {
      window.print();
    }
</script>