<?php

require_once('core/database/dbconfig.php');

class USER
{

	private $conn;

	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
  }

	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}


	//Register a new user in the database
	public function register($uname,$umail,$upass)
	{
		try
		{
			$new_password = password_hash($upass, PASSWORD_DEFAULT);

			$stmt = $this->conn->prepare("INSERT INTO users(user_name,user_email,user_pass)
		                                               VALUES(:uname, :umail, :upass)");

			$stmt->bindparam(":uname", $uname);
			$stmt->bindparam(":umail", $umail);
			$stmt->bindparam(":upass", $new_password);

			$stmt->execute();

			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	//Login to site using valid information that is checked against the database
	public function doLogin($uname,$umail,$upass)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM users WHERE user_name=:uname OR user_email=:umail ");
			$stmt->execute(array(':uname'=>$uname, ':umail'=>$umail));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
			{
				if(password_verify($upass, $userRow['user_pass']))
				{
					$_SESSION['user_session'] = $userRow['user_id'];
					if ($userRow['roles'] == "1") {
						$_SESSION['staff'] = $userRow['roles'];
					} else {
						$_SESSION['staff'] = 'false';
					}
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	//check if a user is logged in
	public function is_loggedin()
	{
		if(isset($_SESSION['user_session']))
		{
			return true;
		}
	}

	//redierect to $url
	public function redirect($url)
	{
		header("Location: $url");
	}

	//Log user out
	public function doLogout()
	{
		session_destroy();
		unset($_SESSION['user_session']);
		return true;
	}

	public function checkRole($user_id) {
		try {
			$stmt = $this->conn->prepare("SELECT roles FROM users WHERE user_id=:uid");
			$stmt->execute(array(':uid'=>$user_id));
			if($userRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
				if($userRow['roles'] == 1) {
					return true;
				} else {
					return false;
				}
			}
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function addProduct($bookn,$author,$book_description,$quantity,$price,$userpic)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO books(book_title, author, book_description, quantity, price, book_img)
																									 VALUES(:bookn, :author, :bookd, :quant, :price, :bookImg)");

			$stmt->bindparam(":bookn", $bookn);
			$stmt->bindparam(":author", $author);
			$stmt->bindparam(":bookd", $book_description);
			$stmt->bindparam(":quant", $quantity);
			$stmt->bindparam(":price", $price);
			$stmt->bindparam(":bookImg", $userpic);

			$stmt->execute();

			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	public function updateProduct($bookn,$author,$book_description,$quantity,$price,$userpic,$bookid)
	{
		try
		{
			$stmt = $this->conn->prepare("UPDATE books
				SET book_title=:bookn, author=:author, book_description=:bookd, quantity=:quant, price=:price, book_img=:bookImg
				WHERE bookID=:bookid");

			$stmt->bindparam(":bookn", $bookn);
			$stmt->bindparam(":author", $author);
			$stmt->bindparam(":bookd", $book_description);
			$stmt->bindparam(":quant", $quantity);
			$stmt->bindparam(":price", $price);
			$stmt->bindparam(":bookImg", $userpic);
			$stmt->bindparam(":bookid", $bookid);

			$stmt->execute();

			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	public function deleteProduct($bookID) {
		try {
			$stmt = $this->conn->prepare("DELETE FROM books WHERE bookID=:bookid");
			$stmt->bindparam('bookid', $bookID);

			$stmt->execute();

			return $stmt;

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function retrieveByBookID($bookid, $bookTitle) {
		try {
			$stmt = $this->conn->prepare("SELECT * FROM books WHERE book_title=:bookT AND bookID=:bookid");
			$stmt->bindparam('bookT', $bookTitle);
			$stmt->bindparam('bookid', $bookid);

			$stmt->execute();

			return $stmt;

		} catch (Exception $e) {
				echo $e->getMessage();
		}
	}

	public function updateBookQuantityPlus($bookID) {
		try {
			$stmt = $this->conn->prepare("UPDATE books SET quantity=quantity + 1 WHERE bookID=:bookid");
			$stmt->bindparam('bookid', $bookID);

			$stmt->execute();

			return $stmt;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function updateBookQuantityMinus($bookID) {
		try {
			$stmt = $this->conn->prepare("UPDATE books SET quantity=quantity - 1 WHERE bookID=:bookid");
			$stmt->bindparam('bookid', $bookID);
			$stmt->execute();

			return $stmt;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function retrieveApproveCartID($userid) {
		try {
			$stmt = $this->conn->prepare("SELECT acartID FROM approve_cart WHERE userID=:uid");
			$stmt->bindparam('uid', $userid);
			$stmt->execute();

			return $stmt;
		} catch (Exception $e) {
			echo $e->getMessage();
		}

	}
}
?>
