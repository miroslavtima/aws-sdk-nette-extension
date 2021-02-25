[![Latest Stable Version](https://poser.pugx.org/miroslavtima/aws-sdk-nette-extension/v/stable)](https://packagist.org/packages/miroslavtima/aws-sdk-nette-extension)
[![License](https://poser.pugx.org/miroslavtima/aws-sdk-nette-extension/license)](https://packagist.org/packages/miroslavtima/aws-sdk-nette-extension)
[![Total Downloads](https://poser.pugx.org/miroslavtima/aws-sdk-nette-extension/downloads)](https://packagist.org/packages/miroslavtima/aws-sdk-nette-extension)

# aws-sdk-nette-extension
A Nette extension for the AWS SDK for PHP https://aws.amazon.com/sdk-for-php/  
Inspired by https://github.com/ublaboo/aws-sdk-nette-extension, but you can use all AWS SDK library now :-)

## Installation

Download extension using composer

```
composer require miroslavtima/aws-sdk-nette-extension
```

Register extension in your config.neon file:

``` 
extensions:
	aws: MT\AwsSdkNetteExtension\DI\AwsSdkNetteExtension
```

## Configuration

Configure extension in your `config.neon` file:

``` 
aws:
	region: eu-west-1
	version: latest
```

And put your key and secret in your `config.local.neon` file (which should not be versioned)

``` 
aws:
	credentials:
		key: your_access_key
		secret: your_secret_access_key
```
			
## Usage

Ideally create some services wrapping the S3 client with your logic inside them

```php
class S3Service
{

	/**
	 * @var \Aws\S3\S3Client
	 */
	public $s3;


	public function __construct(\Aws\Sdk $sdk)
	{
		$this->s3 = $sdk->createS3();
	}


	public function save($path_to_file)
	{
		$this->s3->putObject([
			'Bucket'     => 'YourBucket',
			'Key'        => 'YourObjectKey',
			'SourceFile' => $path_to_file,
		]);
	}

}
```

And use them in your presenters:

```php
class HomepagePresenter extends Presenter
{

	/**
	 * @var S3Service
	 * @inject
	 */
	public $service;


	public function actionDefault()
	{
		$this->service->save('/path/to/file');
	}

}
```

