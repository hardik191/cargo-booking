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
														<img alt="Logo" src="{{asset('backend/upload/system_setting/logo.png')}}" style="height: 135px" />
													</a>
												</div>
												<!--end:Logo-->
												<!--begin:Media-->
												<div style="margin-bottom:15px">
													<img alt="Logo" src="{{asset('backend/media/email/icon-positive-vote-1.svg')}}" />
												</div>
												<!--end:Media-->

												<!--begin:Text-->
												<div style="text-align:start; font-size: 13px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif; margin-left: 20px;">
													<p style="margin-bottom:9px; color:#181C32; font-size: 18px; font-weight:600">Dear {{$name}},</p>
													<p style="margin-bottom:10px; color:#5E6278">We are delighted to inform you that your account with {{$general_setting_details->system_name}} has been successful update password. Below are your account details:
                                                    </p>
                                                    <ul style="margin-bottom: 10px; color: #5E6278; list-style: none; padding-left: 0;">
                                                        <li style="margin-bottom: 2px; color: #5E6278;">
                                                            <span style="color: black;"><b>Email:</b></span> {{ $email }}
                                                        </li>
                                                        <li style="margin-bottom: 10px; color: #5E6278;">
                                                            <span style="color: black;"><b>Password:</b></span> {{$password}}
                                                        </li>
                                                    </ul>
                                                
													<p style="margin-bottom:10px; color:#5E6278;">Please keep this information secure and do not share it with anyone.</p>

													{{-- <p style="margin-bottom:10px; color:#5E6278">You can log in to your account at [Login URL] to start using our services.</p> --}}


													<p style="margin-bottom:10px; color:#5E6278">If you have any questions or need assistance, please do not hesitate to contact our support team.</p>


													<p style="margin-bottom:10px; color:#5E6278">Welcome aboard!

													</p>
                                                    <p style="margin-bottom:0px; color:#5E6278">
                                                        Best regards,
													</p>
                                                    <p style="margin-bottom:0px; color:#5E6278">
                                                        {{$general_setting_details->system_name}}
													</p>
													<!--end:Text-->

													<!--end:Email content-->

													<tr style="display: flex; justify-content: center; margin:0 60px 35px 60px">
														
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
