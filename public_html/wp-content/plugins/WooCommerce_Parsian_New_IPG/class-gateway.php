<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Woocommerce_Ir_Gateway_Parsian_New' ) ) :

	Persian_Woocommerce_Gateways::register( 'Parsian_New' );

	class Woocommerce_Ir_Gateway_Parsian_New extends Persian_Woocommerce_Gateways {

		public function __construct() {

			$this->method_title = 'پارسیان جدید';

			parent::init( $this );
		}

		public function fields() {
			return array(
				'pin'        => array(
					'title'       => 'پین کد',
					'type'        => 'text',
					'description' => 'پین کد درگاه پارسیان',
					'default'     => '',
					'desc_tip'    => true
				),
				'shortcodes' => array(
					'transaction_id'   => 'کد رهگیری (شماره RNN ارجاع بانکی)',
					'Token'            => 'شماره درخواست',
					'CardNumberMasked' => 'قسمتی از شماره کارت پرداخت کننده',
				)
			);
		}

		public function request( $order ) {

			$this->nusoap();

			$Pin         = $this->option( 'pin' );
			$Amount      = $this->get_total( 'IRR' );
			$CallBackUrl = $this->get_verify_url();
			$ResNum      = time();

			try {

				$client                   = new nusoap_client( 'https://pec.shaparak.ir/NewIPGServices/Sale/SaleService.asmx?WSDL', 'wsdl' );
				$client->soap_defencoding = 'UTF-8';
				$client->decode_utf8      = false;
				$soapclient               = $client->getProxy();
				$Result                   = $soapclient->SalePaymentRequest( array(
					'requestData' => array(
						'LoginAccount'   => $Pin,
						'OrderId'        => $ResNum,
						'Amount'         => $Amount,
						'CallBackUrl'    => $CallBackUrl,
						'AdditionalData' => ''
					)
				) );

				$Result = (array) $Result;

				$Status  = isset( $Result['SalePaymentRequestResult']['Status'] ) ? $Result['SalePaymentRequestResult']['Status'] : '';
				$Token   = isset( $Result['SalePaymentRequestResult']['Token'] ) ? $Result['SalePaymentRequestResult']['Token'] : '';
				$Message = ! empty( $Result['SalePaymentRequestResult']['Message'] ) ? $Result['SalePaymentRequestResult']['Message'] : '';

				if ( $Status == '0' && ! empty( $Token ) && $Token > 0 ) {
					return $this->redirect( 'https://pec.shaparak.ir/NewIPG/?Token=' . $Token );
				} else {
					$error = array( trim( $Message ), trim( $this->errors( $Status ) ) );

					return implode( ' :: ', array_unique( array_filter($error) ) );
				}

			} catch ( SoapFault $e ) {
				return $e->getMessage();
			}
		}

		public function verify( $order ) {

			$this->nusoap();

			$Pin       = $this->option( 'pin' );
			$PayStatus = $this->post( 'status', '0' );
			$Token     = $this->post( 'Token' );
			//$OrderId    = $this->post( 'OrderId' );
			//$TerminalNo = $this->post( 'TerminalNo' );
			//$Amount     = $this->post( 'Amount' );
			$RRN = $this->post( 'RRN' );

			$this->check_verification( $Token );

			$status           = 'failed';
			$ErrorCode        = $ReversalErrorCode = 0;
			$CardNumberMasked = '';
			if ( $PayStatus == '0' && $RRN > 0 && $Token > 0 ) {

				try {

					$client                   = new nusoap_client( 'https://pec.shaparak.ir/NewIPGServices/Confirm/ConfirmService.asmx?WSDL', 'wsdl' );
					$client->soap_defencoding = 'UTF-8';
					$client->decode_utf8      = false;
					$soapclient               = $client->getProxy();
					$Result                   = $soapclient->ConfirmPayment( array(
						'requestData' => array(
							'LoginAccount' => $Pin,
							'Token'        => $Token
						)
					) );

					$Result = (array) $Result;

					$PayStatus = isset( $Result['ConfirmPaymentResult']['Status'] ) ? $Result['ConfirmPaymentResult']['Status'] : '';
					$RRN       = isset( $Result['ConfirmPaymentResult']['RRN'] ) ? $Result['ConfirmPaymentResult']['RRN'] : '';
					//$Token            = ! empty( $Result['ConfirmPaymentResult']['Token'] ) ? $Result['ConfirmPaymentResult']['Token'] : '';
					$CardNumberMasked = ! empty( $Result['ConfirmPaymentResult']['CardNumberMasked'] ) ? $Result['ConfirmPaymentResult']['CardNumberMasked'] : '';

					if ( $PayStatus == '0' && ! empty( $RRN ) && $RRN > 0 ) {
						$status = 'completed';
					} else {
						$ErrorCode = $PayStatus;
					}

				} catch ( SoapFault $e ) {
					$Message = $e->getMessage();
				}

				if ( $status != 'completed' ) {

					try {
						$client                   = new nusoap_client( 'https://pec.shaparak.ir/NewIPGServices/Reverse/ReversalService.asmx?WSDL', 'wsdl' );
						$client->soap_defencoding = 'UTF-8';
						$client->decode_utf8      = false;
						$soapclient               = $client->getProxy();
						$Result                   = $soapclient->ReversalRequest( array(
							"requestData" => array(
								'LoginAccount' => $Pin,
								'Token'        => $Token
							)
						) );

						$Result    = (array) $Result;
						$RevStatus = isset( $Result['ReversalRequestResult']['Status'] ) ? $Result['ReversalRequestResult']['Status'] : '';
						//$Token = isset($Result['ReversalRequestResult']['Token']) ? $Result['ReversalRequestResult']['Token'] : '';

						if ( $RevStatus != '0' ) {
							$ReversalErrorCode = $RevStatus;
							$ReversalMessage   = isset( $Result['ReversalRequestResult']['Message'] ) ? $Result['ReversalRequestResult']['Message'] : '';
						}

					} catch ( SoapFault $e ) {
						$ReversalMessage = $e->getMessage();
					}
				}

			} elseif ( $PayStatus == '-138' ) {
				$status = 'cancelled';
			} else {
				$ErrorCode = $PayStatus;
			}

			$error   = array();
			$error[] = ! empty( $Message ) ? $Message : '';
			$error[] = ! empty( $ErrorCode ) ? $this->errors( $ErrorCode ) : '';
			if ( ! empty( $ReversalErrorCode ) || ! empty( $ReversalMessage ) ) {
				$ReversalError   = array();
				$ReversalError[] = ! empty( $ReversalMessage ) ? $ReversalMessage : '';
				$ReversalError[] = ! empty( $ReversalErrorCode ) ? $this->errors( $ReversalErrorCode ) : '';
				if ( ! empty( $ReversalError ) ) {
					$error[] = 'تراکنش ناموفق برگشت نخورده است زیرا: ' . implode( ' | ', array_filter( $ReversalError ) );
				}
			}

			$error          = ! empty( $error ) ? implode( ' ::: ', array_filter( $error ) ) : 'خطایی رخ داده است.';
			$transaction_id = $RRN;


			$this->set_shortcodes( array(
				'transaction_id'   => $transaction_id,
				'Token'            => $Token,
				'CardNumberMasked' => $CardNumberMasked
			) );

			return compact( 'status', 'transaction_id', 'error' );
		}

		private function errors( $error ) {

			switch ( $error ) {

				case '-32768':
					$message = 'خطای ناشناخته رخ داده است';
					break;
				case '-1552':
					$message = 'برگشت تراکنش مجاز نمی باشد';
					break;
				case '-1551':
					$message = 'برگشت تراکنش قبلاً انجام شده است';
					break;
				case '-1550':
					$message = 'برگشت تراکنش در وضعیت جاری امکان پذیر نمی باشد';
					break;
				case '-1549':
					$message = 'زمان مجاز برای درخواست برگشت تراکنش به اتمام رسیده است';
					break;
				case '-1548':
					$message = 'فراخوانی سرویس درخواست پرداخت قبض ناموفق بود';
					break;
				case '-1540':
					$message = 'تاييد تراکنش ناموفق مي باشد';
					break;
				case '-1536':
					$message = 'فراخوانی سرویس درخواست شارژ تاپ آپ ناموفق بود';
					break;
				case '-1533':
					$message = 'تراکنش قبلاً تایید شده است';
					break;
				case '1532':
					$message = 'تراکنش از سوی پذیرنده تایید شد';
					break;
				case '-1531':
					$message = 'تراکنش به دلیل انصراف شما در بانک ناموفق بود';
					break;
				case '-1530':
					$message = 'پذیرنده مجاز به تایید این تراکنش نمی باشد';
					break;
				case '-1528':
					$message = 'اطلاعات پرداخت یافت نشد';
					break;
				case '-1527':
					$message = 'انجام عملیات درخواست پرداخت تراکنش خرید ناموفق بود';
					break;
				case '-1507':
					$message = 'تراکنش برگشت به سوئیچ ارسال شد';
					break;
				case '-1505':
					$message = 'تایید تراکنش توسط پذیرنده انجام شد';
					break;
				case '-132':
					$message = 'مبلغ تراکنش کمتر از حداقل مجاز می باشد';
					break;
				case '-131':
					$message = 'Token نامعتبر می باشد';
					break;
				case '-130':
					$message = 'Token زمان منقضی شده است';
					break;
				case '-128':
					$message = 'قالب آدرس IP معتبر نمی باشد';
					break;
				case '-127':
					$message = 'آدرس اینترنتی معتبر نمی باشد';
					break;
				case '-126':
					$message = 'کد شناسایی پذیرنده معتبر نمی باشد';
					break;
				case '-121':
					$message = 'رشته داده شده بطور کامل عددی نمی باشد';
					break;
				case '-120':
					$message = 'طول داده ورودی معتبر نمی باشد';
					break;
				case '-119':
					$message = 'سازمان نامعتبر می باشد';
					break;
				case '-118':
					$message = 'مقدار ارسال شده عدد نمی باشد';
					break;
				case '-117':
					$message = 'طول رشته کم تر از حد مجاز می باشد';
					break;
				case '-116':
					$message = 'طول رشته بیش از حد مجاز می باشد';
					break;
				case '-115':
					$message = 'شناسه پرداخت نامعتبر می باشد';
					break;
				case '-114':
					$message = 'شناسه قبض نامعتبر می باشد';
					break;
				case '-113':
					$message = 'پارامتر ورودی خالی می باشد';
					break;
				case '-112':
					$message = 'شماره سفارش تکراری است';
					break;
				case '-111':
					$message = 'مبلغ تراکنش بیش از حد مجاز پذیرنده می باشد';
					break;
				case '-108':
					$message = 'قابلیت برگشت تراکنش برای پذیرنده غیر فعال می باشد';
					break;
				case '-107':
					$message = 'قابلیت ارسال تاییده تراکنش برای پذیرنده غیر فعال می باشد';
					break;
				case '-106':
					$message = 'قابلیت شارژ برای پذیرنده غیر فعال می باشد';
					break;
				case '-105':
					$message = 'قابلیت تاپ آپ برای پذیرنده غیر فعال می باشد';
					break;
				case '-104':
					$message = 'قابلیت پرداخت قبض برای پذیرنده غیر فعال می باشد';
					break;
				case '-103':
					$message = 'قابلیت خرید برای پذیرنده غیر فعال می باشد';
					break;
				case '-102':
					$message = 'تراکنش با موفقیت برگشت داده شد';
					break;
				case '-101':
					$message = 'پذیرنده اهراز هویت نشد';
					break;
				case '-100':
					$message = 'پذیرنده غیرفعال می باشد';
					break;
				case '-1':
					$message = 'خطای سرور';
					break;
				case '0':
					$message = 'عملیات موفق می باشد';
					break;
				case '1':
					$message = 'صادرکننده ی کارت از انجام تراکنش صرف نظر کرد';
					break;
				case '2':
					$message = 'عملیات تاییدیه این تراکنش قبلا باموفقیت صورت پذیرفته است';
					break;
				case '3':
					$message = 'پذیرنده ی فروشگاهی نامعتبر می باشد';
					break;
				case '5':
					$message = 'از انجام تراکنش صرف نظر شد';
					break;
				case '6':
					$message = 'بروز خطايي ناشناخته';
					break;
				case '8':
					$message = 'باتشخیص هویت دارنده ی کارت، تراکنش موفق می باشد';
					break;
				case '9':
					$message = 'درخواست رسيده در حال پي گيري و انجام است ';
					break;
				case '10':
					$message = 'تراکنش با مبلغي پايين تر از مبلغ درخواستي ( کمبود حساب مشتري ) پذيرفته شده است ';
					break;
				case '12':
					$message = 'تراکنش نامعتبر است';
					break;
				case '13':
					$message = 'مبلغ تراکنش نادرست است';
					break;
				case '14':
					$message = 'شماره کارت ارسالی نامعتبر است (وجود ندارد)';
					break;
				case '15':
					$message = 'صادرکننده ی کارت نامعتبراست (وجود ندارد)';
					break;
				case '17':
					$message = 'مشتري درخواست کننده حذف شده است ';
					break;
				case '20':
					$message = 'در موقعيتي که سوئيچ جهت پذيرش تراکنش نيازمند پرس و جو از کارت است ممکن است درخواست از کارت ( ترمينال) بنمايد اين پيام مبين نامعتبر بودن جواب است';
					break;
				case '21':
					$message = 'در صورتي که پاسخ به در خواست ترمينا ل نيازمند هيچ پاسخ خاص يا عملکردي نباشيم اين پيام را خواهيم داشت ';
					break;
				case '22':
					$message = 'تراکنش مشکوک به بد عمل کردن ( کارت ، ترمينال ، دارنده کارت ) بوده است لذا پذيرفته نشده است';
					break;
				case '30':
					$message = 'قالب پیام دارای اشکال است';
					break;
				case '31':
					$message = 'پذیرنده توسط سوئی پشتیبانی نمی شود';
					break;
				case '32':
					$message = 'تراکنش به صورت غير قطعي کامل شده است ( به عنوان مثال تراکنش سپرده گزاري که از ديد مشتري کامل شده است ولي مي بايست تکميل گردد';
					break;
				case '33':
					$message = 'تاریخ انقضای کارت سپری شده است';
					break;
				case '38':
					$message = 'تعداد دفعات ورود رمزغلط بیش از حدمجاز است. کارت توسط دستگاه ضبط شود';
					break;
				case '39':
					$message = 'کارت حساب اعتباری ندارد';
					break;
				case '40':
					$message = 'عملیات درخواستی پشتیبانی نمی گردد';
					break;
				case '41':
					$message = 'کارت مفقودی می باشد';
					break;
				case '43':
					$message = 'کارت مسروقه می باشد';
					break;
				case '45':
					$message = 'قبض قابل پرداخت نمی باشد';
					break;
				case '51':
					$message = 'موجودی کافی نمی باشد';
					break;
				case '54':
					$message = 'تاریخ انقضای کارت سپری شده است';
					break;
				case '55':
					$message = 'رمز کارت نا معتبر است';
					break;
				case '56':
					$message = 'کارت نا معتبر است';
					break;
				case '57':
					$message = 'انجام تراکنش مربوطه توسط دارنده ی کارت مجاز نمی باشد';
					break;
				case '58':
					$message = 'انجام تراکنش مربوطه توسط پایانه ی انجام دهنده مجاز نمی باشد';
					break;
				case '59':
					$message = 'کارت مظنون به تقلب است';
					break;
				case '61':
					$message = 'مبلغ تراکنش بیش از حد مجاز می باشد';
					break;
				case '62':
					$message = 'کارت محدود شده است';
					break;
				case '63':
					$message = 'تمهیدات امنیتی نقض گردیده است';
					break;
				case '65':
					$message = 'تعداد درخواست تراکنش بیش از حد مجاز می باشد';
					break;
				case '68':
					$message = 'پاسخ لازم براي تکميل يا انجام تراکنش خيلي دير رسيده است';
					break;
				case '69':
					$message = 'تعداد دفعات تکرار رمز از حد مجاز گذشته است ';
					break;
				case '75':
					$message = 'تعداد دفعات ورود رمزغلط بیش از حدمجاز است';
					break;
				case '78':
					$message = 'کارت فعال نیست';
					break;
				case '79':
					$message = 'حساب متصل به کارت نا معتبر است یا دارای اشکال است';
					break;
				case '80':
					$message = 'درخواست تراکنش رد شده است';
					break;
				case '81':
					$message = 'کارت پذيرفته نشد';
					break;
				case '83':
					$message = 'سرويس دهنده سوئيچ کارت تراکنش را نپذيرفته است';
					break;
				case '84':
					$message = 'در تراکنشهايي که انجام آن مستلزم ارتباط با صادر کننده است در صورت فعال نبودن صادر کننده اين پيام در پاسخ ارسال خواهد شد ';
					break;
				case '91':
					$message = 'سيستم صدور مجوز انجام تراکنش موقتا غير فعال است و يا  زمان تعيين شده براي صدور مجوز به پايان رسيده است';
					break;
				case '92':
					$message = 'مقصد تراکنش پيدا نشد';
					break;
				case '93':
					$message = 'امکان تکميل تراکنش وجود ندارد';
					break;
				default:
					$message = 'خطایی رخ داده است.';
			}

			return $message;
		}
	}
endif;