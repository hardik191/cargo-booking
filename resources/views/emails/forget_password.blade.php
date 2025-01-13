<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: MetronicProduct Version: 8.2.5
Purchase: https://1.envato.market/EA4JP
Website: http://www.keenthemes.com
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
	<!--begin::Head-->
	<head>
		<meta charset="utf-8" />
		<script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
	</head>

    @php
        $get_system_setting = get_system_setting('general_setting');
        $general_setting_details = json_decode($get_system_setting['value']);

		$get_branding_setting = get_system_setting('branding');
		$branding_setting_details = json_decode($get_branding_setting['value']);
    @endphp
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="app-blank">
		<!--begin::Theme mode setup on page load-->

		<!--end::Theme mode setup on page load-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<!--begin::Wrapper-->
			<div class="d-flex flex-column flex-column-fluid">
				<!--begin::Body-->
				<div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
					<!--begin::Email template-->
					<style>html,body { padding:0; margin:0; font-family: Inter, Helvetica, "sans-serif"; } a:hover { color: #009ef7; }</style>
                    <br>
					<div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044;  padding:0; width:100%;">
						<div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 800px;">
							<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
								<tbody>
									<tr>
										<td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
											<!--begin:Email content-->
											<div style="text-align:center; margin:-74px 60px 34px 100px">
												<!--begin:Logo-->
												<div style="margin-bottom:5px">

													<a href="{{route('login')}}" rel="noopener" target="_blank">
														
														<img class="" src="{{ asset('backend/upload/system_setting/' . $branding_setting_details->login_icon_name) }}" style="width: 300px;" alt="{{ $general_setting_details->system_name }}"/>
													</a>

												</div>
												<!--end:Logo-->
												<!--begin:Media-->
											
												<!--end:Media-->
												<!--end:Text-->
												<!--begin:Action-->
												<!--begin:Text-->
												{{-- <a href="{{ route('reset-password', $token) }}" target="_blank" style="background-color:#50cd89; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500; font-family:Arial,Helvetica,sans-serif;">Change Password</a> --}}

												<div style="text-align:start; font-size: 13px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif; margin-left: 20px;">
													<p style="margin-bottom:9px; color:#181C32; font-size: 18px; font-weight:600">Dear {{$name}},</p>
													<p style="margin-bottom:10px; color:#5E6278">We received a request to reset your password for your {{$general_setting_details->system_name}} account. If you made this request, please click the link below to reset your password:</p>
													<p style="margin-bottom:10px; color:#5E6278;">Please keep this information secure and do not share it with anyone.</p>
													
													<span>                                                	
														<a href="{{ route('reset-password', $token) }}" target="_blank" style="background-color:#50cd89; border-radius:6px; display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500; font-family:Arial,Helvetica,sans-serif; text-decoration:none;">Reset Password</a>
													</span>
													
													<p style="margin-bottom:10px; color:#5E6278">If the above button does not work, you can copy and paste the following link into your web browser:
													</p>

													<p> <a href="{{ route('reset-password', $token) }}" target="_blank" style="">{{ route('reset-password', $token) }}</a>
													</p>
													<p style="margin-bottom:10px; color:#5E6278">For security purposes, this link will expire in 24 hours. If you did not request a password reset, please ignore this email or contact our support team immediately.
													</p>

													<p style="margin-bottom:10px; color:#5E6278">If you have any questions or need further assistance, feel free to reach out to our support team at</p>

													<p>Thank you for using 
														<a href="mailto:{{$general_setting_details->system_email ?? ''}}">{{$general_setting_details->system_email ?? ''}}</a>
													</p>
                                                    <p style="margin-bottom:0px; color:#5E6278">
                                                        Best regards, <br> {{$general_setting_details->system_name}}
													</p>
													<!--end:Text-->

													<!--end:Email content-->

													<tr style="display: flex; justify-content: center; margin:0 60px 35px 60px">
														<td align="start" valign="start" style="padding-bottom: 10px;">
														
														</td>
													</tr>
													<!--end::Email template-->
													<!--end::Body-->
													<!--end::Wrapper-->
													<!--end::Root-->
													<!--begin::Javascript-->
													<script>var hostUrl = "assets/";</script>
													<!--begin::Global Javascript Bundle(mandatory for all pages)-->
													<script src="assets/plugins/global/plugins.bundle.js"></script>
													<script src="assets/js/scripts.bundle.js"></script>
													<!--end::Global Javascript Bundle-->
													<!--end::Javascript-->
													<!--end::Body--></p>
												</div>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
                    <br>
				</div>
			</div>
		</div>
	</body>
</html>
