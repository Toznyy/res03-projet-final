<?php

class AddressManager extends AbstractManager {

    public function getAllAddresses() : array {
        
        $query = $this->db->prepare("SELECT * FROM addresses");
        $query->execute();
        $addresses = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $addressesTab=[];
        foreach($addresses as $address){
            $newAddress = new Address($address['street'], $address['number'], $address['postal_code'], $address['city']);
            $newAddress->setId($address['id']);
            array_push($addressesTab, $newAddress);
        }
        return $addressesTab;
    }

    public function getAddressById(?int $id) : Adress {
        
        $query = $this->db->prepare("SELECT * FROM addresses WHERE id = :id");
        $parameters = [
            "id" => $id
            ];
        $query->execute($parameters);
        $address = $query->fetch(PDO::FETCH_ASSOC);
        $newAddress = new Address($address['street'], $address['number'], $address['postal_code'], $address['city']);
        $newAddress->setId($address['id']);
        return $newAddress;
    }
    
    public function getAddressesByUser(User $user) : Address {
        
        $query = $this->db->prepare("SELECT * FROM users JOIN (users_addresses JOIN addresses ON users_addresses.address_id = users.id) ON addresses.id = users_addresses.user_id");
        $query->execute();
        $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createAdress(Address $address) : Address {
        
        $query = $this->db->prepare("INSERT INTO addresses VALUES (null, :street, :number, :postal_code, :city)");
        $parameters = [
            "street" => $address->getStreet(),
            "number" => $address->getNumber(),
            "postal_code" => $address->getPostalCode(),
            "city" => $address->getCity(),
            ];
        $query->execute($parameters);

        $query = $this->db->prepare("SELECT * FROM addresses WHERE id = :id");
        $parameters= [
            "id" => $address->getId(),
            ];
        $query->execute($parameters);
        $address = $query->fetch(PDO::FETCH_ASSOC);
        $newAddress = new Address($address['street'], $address['number'], $address['postal_code'], $address['city']);
        $newAddress->setId($address['id']);
        return $newAddress;
    }

    public function updateAddress(Address $address) : void {
        
        $query = $this->db->prepare("UPDATE addresses SET street = :street, number = :number, postal_code = :postal_code, city = :city WHERE id = :id");
        $parameters= [
            "street" => $address->getStreet(),
            "number" => $address->getNumber(),
            "postal_code" => $address->getPostalCode(),
            "city" => $address->getCity(),
            ];
        $query->execute($parameters);
    }

    public function deleteAddress(Adress $address) : void {
        $query = $this->db->prepare("DELETE FROM addresses WHERE id = :id");
        $parameters = ["id" => $Adress->getId()];
        $query->execute($parameters);
    }
}

?>