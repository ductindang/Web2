<?php


class Order
{
	public $id;
	public $created_date;
	public $status;
	public $user_id;
	public $payment_method;
	public $shipping_fee;
	public $delivered_date;
	public $cus_fullname;
	public $cus_mobile;
	public $cus_address;
	public $total_money;

	function __construct($id, $created_date, $status, $user_id, $payment_method, $shipping_fee, $delivered_date, $cus_fullname, $cus_mobile, $cus_address, $total_money)
	{
		$this->id = $id;
		$this->created_date = $created_date;
		$this->status = $status;
		$this->user_id = $user_id;
		$this->payment_method = $payment_method;
		$this->shipping_fee = $shipping_fee;
		$this->delivered_date = $delivered_date;
		$this->cus_fullname = $cus_fullname;
		$this->cus_mobile = $cus_mobile;
		$this->cus_address = $cus_address;
		$this->total_money = $total_money;
	}



	function getId()
	{
		return $this->id;
	}

	function getCreatedDate()
	{
		return $this->created_date;
	}

	function getStaffId()
	{
		return $this->staff_id;
	}

	function getCustomerId()
	{
		return $this->user_id;
	}

	function getShippingFullname()
	{
		return $this->shipping_fullname;
	}



	function getPaymentMethod()
	{
		return $this->payment_method;
	}

	function getShippingWardId()
	{
		return $this->shipping_ward_id;
	}

	function getShippingHousenumberStreet()
	{
		return $this->shipping_housenumber_street;
	}

	function getShippingFee()
	{
		return $this->shipping_fee;
	}

	function getDeliveredDate()
	{
		return $this->delivered_date;
	}

	function setCreatedDate($created_date)
	{
		$this->created_date = $created_date;
		return $this;
	}

	function setStatus($status)
	{
		$this->status = $status;
		return $this;
	}

	function setStaffId($staff_id)
	{
		$this->staff_id = $staff_id;
		return $this;
	}

	function setCustomerId($user_id)
	{
		$this->user_id = $user_id;
		return $this;
	}

	function setShippingFullname($shipping_fullname)
	{
		$this->shipping_fullname = $shipping_fullname;
		return $this;
	}

	function setShippingMobile($shipping_mobile)
	{
		$this->shipping_mobile = $shipping_mobile;
		return $this;
	}

	function setPaymentMethod($payment_method)
	{
		$this->payment_method = $payment_method;
		return $this;
	}

	function setShippingWardId($shipping_ward_id)
	{
		$this->shipping_ward_id = $shipping_ward_id;
		return $this;
	}

	function setShippingHousenumberStreet($shipping_housenumber_street)
	{
		$this->shipping_housenumber_street = $shipping_housenumber_street;
		return $this;
	}

	function setShippingFee($shipping_fee)
	{
		$this->shipping_fee = $shipping_fee;
		return $this;
	}

	function setDeliveredDate($delivered_date)
	{
		$this->delivered_date = $delivered_date;
		return $this;
	}


	function getStatus()
	{
		$statusRepository = new StatusRepository();
		$status = $statusRepository->find($this->status);
		return $status;
	}

	function getStaff()
	{
		if (empty($this->staff_id)) return null;
		$staffRepository = new StaffRepository();
		$staff = $staffRepository->find($this->staff_id);
		return $staff;
	}

	function getCustomer()
	{
		$customerRepository = new CustomerRepository();
		$customer = $customerRepository->find($this->user_id);
		return $customer;
	}

	function getShippingWard()
	{
		if (empty($this->shipping_ward_id)) return null; // Kiểm tra nếu shipping_ward_id là null thì không cần thực hiện truy vấn
		$wardRepository = new WardRepository();
		$ward = $wardRepository->find($this->shipping_ward_id);
		return $ward;
	}

	function getOrderItems()
	{
		$orderItemRepository = new OrderItemRepository();
		$orderItems = $orderItemRepository->getByOrderId($this->id);
		return $orderItems;
	}

	function getTotalPrice()
	{
		$totalPrice = 0;
		$orderItems = $this->getOrderItems();
		foreach ($orderItems as $orderItem) {
			$totalPrice += $orderItem->getTotalPrice();
		}
		return $totalPrice;
	}
}
