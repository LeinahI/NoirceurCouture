<?php
require __DIR__ . '/../vendor/autoload.php';

// Load environment variables from the .env file
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Access the encryption key from environment variables
$encryption_key = getenv('ENCRYPTION_KEY');

function encryptData($data)
{
    global $encryption_key;

    $cipher_algo = 'aes-256-cbc'; //+ Set the cipher algorithm to AES-256-CBC
    $key = $encryption_key; //+ Set the encryption key 
    $options = 0; //+ Choose the cipher method and options
    $iv_length = openssl_cipher_iv_length($cipher_algo); //+ Get the length of the initialization vector (IV) for the chosen cipher algorithm
    $iv = openssl_random_pseudo_bytes($iv_length); //+ // Generate a random IV (Initialization Vector)

    $encryptedData = openssl_encrypt($data, $cipher_algo, $key, $options, $iv); //+ Encrypt the data using OpenSSL encrypt function

    $encryptedDataWithIV = base64_encode($iv . $encryptedData); //+ Combine IV and encrypted data and encode it using base64

    return $encryptedDataWithIV; //+ Return the encrypted data with IV
}

function decryptData($encryptedData)
{
    global $encryption_key;

    $cipher_algo = 'aes-256-cbc'; //+ Set the cipher algorithm to AES-256-CBC
    $key = $encryption_key; //+ Set the encryption key
    $options = 0; //+ Choose the cipher method and options
    $encryptedDataWithIV = base64_decode($encryptedData);  //+ Decode the base64-encoded string to extract IV and encrypted data
    $iv_length = openssl_cipher_iv_length($cipher_algo); //+ Get the length of the initialization vector (IV) for the chosen cipher algorithm
    $iv = substr($encryptedDataWithIV, 0, $iv_length); //+ Extract IV from the combined IV and encrypted data string

    $encrptedDataWithoutIV = substr($encryptedDataWithIV, $iv_length); //+ Extract encrypted data after IV

    $decryptedData = openssl_decrypt($encrptedDataWithoutIV, $cipher_algo, $key, $options, $iv); //+ Decrypt the data using OpenSSL decrypt function

    return $decryptedData; //+ Return the decrypted data
}