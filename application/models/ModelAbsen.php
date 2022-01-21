<?php
// || \\ array_push($data,['id_cuci' => $key->id_cuci,'nama_cuci' => $key->nama_cuci]);
class ModelAbsen extends CI_Model
{
    public function getAbsensi($year, $month)
    {
        $this->db->select(' id_absen, id_pengguna, absen.tgl_presensi, status');
        $this->db->from('absen');
        $this->db->where('year(absen.tgl_presensi)', $year);
        $this->db->where('month(absen.tgl_presensi)', $month);
        $this->db->group_by('id_pengguna');
        $this->db->order_by('id_pengguna, absen.tgl_presensi', 'asc');
        $res = $this->db->get()->result();

        if (!empty($res))
            return $res;
        else
            return null;
    }

    public function getAbsen($id, $date)
    {
        $this->db->select("v.tgl_presensi, id_pengguna, status from 
(select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) tgl_presensi from
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v");
        $this->db->join('absen', 'absen.tgl_presensi=v.tgl_presensi', 'left');
        $this->db->where("v.tgl_presensi between '" . substr($date, 0, 8) . "01' and '" . $date . "'");
        $this->db->where('(id_pengguna is NULL or id_pengguna = ' . $id . ')');
        $this->db->order_by('v.tgl_presensi', 'DESC');
        $res = $this->db->get()->result();

        if (!empty($res))
            return $res;
        else
            return null;
    }

    public function getAbsen2($id_pengguna, $year, $month)
    {
        $this->db->select(' id_absen, id_pengguna, absen.tgl_presensi, status');
        $this->db->from('absen');
        $this->db->where('id_pengguna', $id_pengguna);
        $this->db->where('year(absen.tgl_presensi)', $year);
        $this->db->where('month(absen.tgl_presensi)', $month);
        $this->db->order_by('absen.tgl_presensi', 'asc');
        $res = $this->db->get()->result();

        if (!empty($res))
            return $res;
        else
            return null;
    }

    public function setColumn($year, $month)
    {
        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $res = '';
        for ($i = 1; $i <= $days; $i++) {
            $date = date('Y-m-d', strtotime($year . '-' . $month . '-' . $i));
            // $res .= 'sum(' . $date . ') as ' . $date . ', ';
            $res .= "coalesce(max(case when v.tgl_presensi = '{$date}' then status end), '') as '{$date}',";
        }
        return substr($res, 0, -1);
    }

    public function getTable($year, $month)
    {
        $query = $this->db->query(
            "SELECT 
                pengguna.id_pengguna ,nama, golongan, definisi, jabatan, tandatangan, nip,  
                {$this->setColumn($year, $month)}
            FROM 
                (select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) tgl_presensi from
                (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
                (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
                (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
                (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
                (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
                right join absen using(tgl_presensi) right join pengguna using(id_pengguna) join golongan using(id_golongan) 
            GROUP BY 
                pengguna.id_pengguna;"
        );

        return $query->result();
    }

    public function postAbsen($data)
    {
        $this->db->insert('absen', $data);
        $res = $this->db->affected_rows();

        return $res;
    }

    public function updateAbsen($data)
    {
        $this->db->or_where('id_absen', $data['id_absen']);
        $this->db->or_where('id_pengguna', $data['id_pengguna']);
        $this->db->where('tgl_presensi', $data['tgl_presensi']);
        $this->db->update('absen', $data);
        $res = $this->db->affected_rows();

        return $res;
    }

    public function deleteAbsen($data)
    {
        $this->db->or_where('id_absen', $data['id_absen']);
        $this->db->or_where('id_pengguna', $data['id_pengguna']);
        $this->db->where('tgl_presensi', $data['tgl_presensi']);
        $this->db->delete('absen');
        $res = $this->db->affected_rows();

        return $res;
    }
}
