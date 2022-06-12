<?php
require_once(dirname(__FILE__).'/product.php');

/**
 * Order model
 */
class Order
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var int
     */
    protected $amount;

    /**
     * @var array
     */
    protected $items;

    /**
     * @var string
     */
    protected $firstname;

    /**
     * @var string
     */
    protected $lastname;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $street;

    /**
     * @var string
     */
    protected $zip;

    /**
     * @var string
     */
    protected $city;

    /**
     * @constructor
     */
    public function __construct(
        $id = null,
        $status = 'new',
        $amount = 0,
        $firstname = null,
        $lastname = null,
        $email = null,
        $street = null,
        $zip = null,
        $city = null,
        $items = []
    )
    {
        $this->setId((int)$id);
        $this->setStatus($status);
        $this->setAmount($amount);
        $this->setFirstname($firstname);
        $this->setLastname($lastname);
        $this->setEmail($email);
        $this->setStreet($street);
        $this->setZip($zip);
        $this->setCity($city);
        $this->setItems($items);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Order
     */
    public function setId(int $id): Order
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return Order
     */
    public function setStatus(string $status): Order
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatusText(): string
    {
        switch ($this->status) {
            case 'new':
                return 'Nouvelle';
            case 'pending':
                return 'En attente de paiement';
            case 'paid':
                return 'Payée. En attente de livraison.';
            case 'delivery':
                return 'Livraison en cours';
            case 'completed':
                return 'Terminée';
            default:
                return 'En erreur';
        }
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     *
     * @return Order
     */
    public function setAmount(int $amount): Order
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     *
     * @return Order
     */
    public function setFirstname(?string $firstname): Order
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     *
     * @return Order
     */
    public function setLastname(?string $lastname): Order
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return Order
     */
    public function setEmail(?string $email): Order
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param string $street
     *
     * @return Order
     */
    public function setStreet(?string $street): Order
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @return string
     */
    public function getZip(): ?string
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     *
     * @return Order
     */
    public function setZip(?string $zip): Order
    {
        $this->zip = $zip;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string $city
     *
     * @return Order
     */
    public function setCity(?string $city): Order
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return (array)$this->items;
    }

    /**
     * @param array $items
     *
     * @return Order
     */
    public function setItems(array $items): Order
    {
        $this->items = $items;
        return $this;
    }

    /**
     * @param stdClass $item
     *
     * @return Order
     */
    public function addItem(Product $item): Order
    {
        $this->items[] = $item;

        $this->_computeAmount();

        return $this;
    }

    /**
     * @param int $index
     *
     * @return Order
     */
    public function removeItem(int $index): Order
    {
        if (isset($this->items[$index])) {
            unset($this->items[$index]);
            $this->items = array_values($this->items);
        }

        $this->_computeAmount();

        return $this;
    }

    protected function _computeAmount()
    {
        $this->amount = 0;
        foreach ($this->items as $item) {
            $this->amount += $item->getPrice();
        }
    }

    public function setPending()
    {
        $this->_computeAmount();
        $this->status = 'pending';
    }

    public function setPaid()
    {
        $this->_computeAmount();
        $this->status = 'paid';
    }

    public function setInDelivery()
    {
        $this->_computeAmount();
        $this->status = 'delivery';
    }

    public function setDelivered()
    {
        $this->_computeAmount();
        $this->status = 'completed';
    }
}
