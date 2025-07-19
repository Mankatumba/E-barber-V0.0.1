<?php
require_once __DIR__ . '/../config/database.php';

class RdvModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = getPDO();
    }
public function create($data)
{
    $stmt = $this->pdo->prepare("
        INSERT INTO rdv (salon_id, user_id, service_id, date, heure, is_domicile, status)
        VALUES (:salon_id, :user_id, :service_id, :date, :heure, :is_domicile, :status)
    ");

    $stmt->execute([
        'salon_id'    => $data['salon_id'],
        'user_id'     => $data['user_id'],
        'service_id'  => $data['service_id'],
        'date'        => $data['date'],
        'heure'       => $data['heure'],
        'is_domicile' => $data['is_domicile'],
        'status'      => $data['status'],
    ]);
}

public function ajouterReservation($salon_id, $client_id, $date_rdv, $heure_rdv, $is_domicile)
{
    $sql = "INSERT INTO rdv (salon_id, client_id, date_rdv, heure_rdv, is_domicile)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$salon_id, $client_id, $date_rdv, $heure_rdv, $is_domicile]);
}

public function annulerReservation($reservation_id, $client_id)
{
    $sql = "DELETE FROM rdv WHERE id = ? AND client_id = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$reservation_id, $client_id]);
}

}
