const t = (source, key, attribute) => { let string = translation[source][key]; if (string && attribute !== undefined) { string  = string.split(" "); for (let i = 0; i < string.length; i++) { if (string[i].startsWith(":")) { string[i] = attribute[string[i].replace(":", "")]; } } string = string.join(" "); } return string; }; var translation = {"validation":{"accepted":"The :attribute field must be accepted.","accepted_if":"The :attribute field must be accepted when :other is :value.","active_url":"The :attribute field must be a valid URL.","after":"The :attribute field must be a date after :date.","after_or_equal":"The :attribute field must be a date after or equal to :date.","alpha":"The :attribute field must only contain letters.","alpha_dash":"The :attribute field must only contain letters, numbers, dashes, and underscores.","alpha_num":"The :attribute field must only contain letters and numbers.","array":"The :attribute field must be an array.","ascii":"The :attribute field must only contain single-byte alphanumeric characters and symbols.","before":"The :attribute field must be a date before :date.","before_or_equal":"The :attribute field must be a date before or equal to :date.","between.array":"The :attribute field must have between :min and :max items.","between.file":"The :attribute field must be between :min and :max kilobytes.","between.numeric":"The :attribute field must be between :min and :max.","between.string":"The :attribute field must be between :min and :max characters.","boolean":"The :attribute field must be true or false.","can":"The :attribute field contains an unauthorized value.","confirmed":"The :attribute field confirmation does not match.","contains":"The :attribute field is missing a required value.","current_password":"The password is incorrect.","date":"The :attribute field must be a valid date.","date_equals":"The :attribute field must be a date equal to :date.","date_format":"The :attribute field must match the format :format.","decimal":"The :attribute field must have :decimal decimal places.","declined":"The :attribute field must be declined.","declined_if":"The :attribute field must be declined when :other is :value.","different":"The :attribute field and :other must be different.","digits":"The :attribute field must be :digits digits.","digits_between":"The :attribute field must be between :min and :max digits.","dimensions":"The :attribute field has invalid image dimensions.","distinct":"The :attribute field has a duplicate value.","doesnt_end_with":"The :attribute field must not end with one of the following: :values.","doesnt_start_with":"The :attribute field must not start with one of the following: :values.","email":"The :attribute field must be a valid email address.","ends_with":"The :attribute field must end with one of the following: :values.","enum":"The selected :attribute is invalid.","exists":"The selected :attribute is invalid.","extensions":"The :attribute field must have one of the following extensions: :values.","file":"The :attribute field must be a file.","filled":"The :attribute field must have a value.","gt.array":"The :attribute field must have more than :value items.","gt.file":"The :attribute field must be greater than :value kilobytes.","gt.numeric":"The :attribute field must be greater than :value.","gt.string":"The :attribute field must be greater than :value characters.","gte.array":"The :attribute field must have :value items or more.","gte.file":"The :attribute field must be greater than or equal to :value kilobytes.","gte.numeric":"The :attribute field must be greater than or equal to :value.","gte.string":"The :attribute field must be greater than or equal to :value characters.","hex_color":"The :attribute field must be a valid hexadecimal color.","image":"The :attribute field must be an image.","in":"The selected :attribute is invalid.","in_array":"The :attribute field must exist in :other.","integer":"The :attribute field must be an integer.","ip":"The :attribute field must be a valid IP address.","ipv4":"The :attribute field must be a valid IPv4 address.","ipv6":"The :attribute field must be a valid IPv6 address.","json":"The :attribute field must be a valid JSON string.","list":"The :attribute field must be a list.","lowercase":"The :attribute field must be lowercase.","lt.array":"The :attribute field must have less than :value items.","lt.file":"The :attribute field must be less than :value kilobytes.","lt.numeric":"The :attribute field must be less than :value.","lt.string":"The :attribute field must be less than :value characters.","lte.array":"The :attribute field must not have more than :value items.","lte.file":"The :attribute field must be less than or equal to :value kilobytes.","lte.numeric":"The :attribute field must be less than or equal to :value.","lte.string":"The :attribute field must be less than or equal to :value characters.","mac_address":"The :attribute field must be a valid MAC address.","max.array":"The :attribute field must not have more than :max items.","max.file":"The :attribute field must not be greater than :max kilobytes.","max.numeric":"The :attribute field must not be greater than :max.","max.string":"The :attribute field must not be greater than :max characters.","max_digits":"The :attribute field must not have more than :max digits.","mimes":"The :attribute field must be a file of type: :values.","mimetypes":"The :attribute field must be a file of type: :values.","min.array":"The :attribute field must have at least :min items.","min.file":"The :attribute field must be at least :min kilobytes.","min.numeric":"The :attribute field must be at least :min.","min.string":"The :attribute field must be at least :min characters.","min_digits":"The :attribute field must have at least :min digits.","missing":"The :attribute field must be missing.","missing_if":"The :attribute field must be missing when :other is :value.","missing_unless":"The :attribute field must be missing unless :other is :value.","missing_with":"The :attribute field must be missing when :values is present.","missing_with_all":"The :attribute field must be missing when :values are present.","multiple_of":"The :attribute field must be a multiple of :value.","not_in":"The selected :attribute is invalid.","not_regex":"The :attribute field format is invalid.","numeric":"The :attribute field must be a number.","password.letters":"The :attribute field must contain at least one letter.","password.mixed":"The :attribute field must contain at least one uppercase and one lowercase letter.","password.numbers":"The :attribute field must contain at least one number.","password.symbols":"The :attribute field must contain at least one symbol.","password.uncompromised":"The given :attribute has appeared in a data leak. Please choose a different :attribute.","present":"The :attribute field must be present.","present_if":"The :attribute field must be present when :other is :value.","present_unless":"The :attribute field must be present unless :other is :value.","present_with":"The :attribute field must be present when :values is present.","present_with_all":"The :attribute field must be present when :values are present.","prohibited":"The :attribute field is prohibited.","prohibited_if":"The :attribute field is prohibited when :other is :value.","prohibited_unless":"The :attribute field is prohibited unless :other is in :values.","prohibits":"The :attribute field prohibits :other from being present.","regex":"The :attribute field format is invalid.","required":"The :attribute field is required.","required_array_keys":"The :attribute field must contain entries for: :values.","required_if":"The :attribute field is required when :other is :value.","required_if_accepted":"The :attribute field is required when :other is accepted.","required_if_declined":"The :attribute field is required when :other is declined.","required_unless":"The :attribute field is required unless :other is in :values.","required_with":"The :attribute field is required when :values is present.","required_with_all":"The :attribute field is required when :values are present.","required_without":"The :attribute field is required when :values is not present.","required_without_all":"The :attribute field is required when none of :values are present.","same":"The :attribute field must match :other.","size.array":"The :attribute field must contain :size items.","size.file":"The :attribute field must be :size kilobytes.","size.numeric":"The :attribute field must be :size.","size.string":"The :attribute field must be :size characters.","starts_with":"The :attribute field must start with one of the following: :values.","string":"The :attribute field must be a string.","timezone":"The :attribute field must be a valid timezone.","unique":"The :attribute has already been taken.","uploaded":"The :attribute failed to upload.","uppercase":"The :attribute field must be uppercase.","url":"The :attribute field must be a valid URL.","ulid":"The :attribute field must be a valid ULID.","uuid":"The :attribute field must be a valid UUID.","custom.attribute-name.rule-name":"custom-message"},"auth":{"failed":"These credentials do not match our records.","password":"The provided password is incorrect.","throttle":"Too many login attempts. Please try again in :seconds seconds.","exists":"Email already exists. Please login.","login":"Login","login_subtitle":"Manage Your Social Campaigns","sign_in_with_google":"Sign in with Google","sign_in_with_github":"Sign in with GitHub","or_with_email":"Or sign in with email","email":"Email","password2":"Password","forgot_password":"Forgot Password?","please_wait":"Please wait...","not_member_yet":"Not a member yet?","register":"Register","register_subtitle":"Join Us Today","sign_up_with_google":"Sign up with Google","sign_up_with_github":"Sign up with GitHub","login_success":"Login successful! Redirecting...","forgot_password_subtitle":"Enter your email to reset your password.","general_error":"An error occurred. Please try again later.","ok":"OK, got it!","cancel":"Cancel","submit":"Submit","reset_password":"Reset Password","reset_password_subtitle":"Already reset your password?","password_hint":"Use 8 or more characters with a mix of letters, numbers & symbols.","password_confirmation":"Confirm Password","password_confirmation_hint":"Re-enter the password for verification.","agree_terms":"I agree to the Terms and Conditions","username":"Username","already_member":"Already a member?","register_success":"Registration successful! Redirecting...","verify_your_email":"Verify Your Email","verify_email_subtitle":"We have sent a verification link to your email. If you did not receive it, check your spam folder.","resend":"Resend","verification_email_sent":"Verification email sent."},"admin":{"sidebar.analytics":"Analytics","sidebar.system_settings":"System Settings","sidebar.roles":"Roles","sidebar.users":"Users","settings.general.title":"General Settings","settings.general.short_title":"General","settings.general.description":"Configure site URL, homepage, theme, and other general settings.","settings.general.app_name":"App Name","settings.general.app_description":"App Description","settings.general.app_url":"App URL","settings.general.app_timezone":"App Timezone","settings.general.app_locale":"App Locale","settings.general.app_theme":"App Theme","settings.general.app_favicon":"App Favicon","settings.general.app_logo_small":"Small App Logo","settings.general.app_logo":"App Logo","settings.general.app_logo_dark":"Dark App Logo","settings.general.save":"Save General Settings","settings.mail.title":"Mail Settings","settings.mail.short_title":"Mail","settings.mail.description":"Configure outgoing email settings.","settings.mail.host":"Mail Host","settings.mail.host_help":"SMTP host for sending emails.","settings.mail.port":"Mail Port","settings.mail.port_help":"SMTP port for sending emails. e.g. 2525, 587 (TLS), 465 (SSL)","settings.mail.username":"Mail Username","settings.mail.username_help":"Username for sending emails.","settings.mail.password":"Mail Password","settings.mail.password_help":"Password for sending emails.","settings.mail.encryption":"Mail Encryption","settings.mail.encryption_help":"Encryption method for sending emails. e.g. tls, ssl","settings.mail.from_address":"Mail From Address","settings.mail.from_address_help":"Email address for sending emails.","settings.mail.from_name":"Mail From Name","settings.mail.from_name_help":"Name displayed in outgoing emails.","settings.mail.save":"Save Mail Settings","settings.logging.title":"Logging Settings","settings.logging.short_title":"Logging","settings.logging.description":"Configure application logging settings.","settings.logging.sentry_laravel_dsn":"Sentry Laravel DSN","settings.logging.sentry_laravel_dsn_help":"DSN for sending errors to Sentry.","settings.logging.sentry_client_key":"Sentry Client Key","settings.logging.sentry_client_key_help":"Client key for sending errors to Sentry.","settings.logging.sentry_traces_sample_rate":"Sentry Traces Sample Rate","settings.logging.sentry_traces_sample_rate_help":"Sample rate for sending traces to Sentry.","settings.logging.note":"Note","settings.logging.sentry_info":"Sentry is a cloud-based error tracking system for software teams.","settings.logging.channel":"Logging Channels","settings.logging.channel_help":"Logging channels. e.g. stack, single, daily, syslog, errorlog, custom","settings.logging.level":"Logging Level","settings.logging.level_help":"Logging level. e.g. emergency, alert, critical, error, warning, notice, info, debug","settings.logging.save":"Save Logging Settings","settings.cache.title":"Cache Settings","settings.cache.short_title":"Cache","settings.cache.description":"Configure application caching settings.","settings.cache.cache_store":"Cache Store","settings.cache.cache_store_help":"Cache store to use. e.g. apc, array, database, file, memcached, redis","settings.cache.cache_prefix":"Cache Prefix","settings.cache.cache_prefix_help":"Prefix to prevent key overlap in cache.","settings.cache.note":"Note","settings.cache.cache_info":"Caching stores copies of data for faster subsequent access.","settings.cache.save":"Save Cache Settings","roles.title":"Roles Management","roles.description":"Manage application roles.","roles.actions.title":"Actions","roles.actions.reload":"Reload","roles.actions.create":"Create Role","roles.actions.search":"Search Roles...","roles.actions.edit":"Edit","roles.actions.delete":"Delete","roles.actions.selected":"Selected","roles.actions.delete_confirmation":"Are you sure you want to delete selected roles?","roles.actions.delete_confirm":"Yes, delete them!","roles.actions.cancel":"No, cancel","roles.actions.delete_success":"Selected roles deleted successfully!","roles.actions.delete_error":"Failed to delete :names role! Ensure it is not the default role.","roles.actions.save":"Save","roles.actions.default_role_cannot_change":"Set another default role before changing this role!","roles.actions.edit_success":"Role :name updated successfully!","roles.actions.create_success":"Role :name created successfully!","roles.columns.name":"Name","roles.columns.guard_name":"Guard","roles.columns.is_default":"Default","roles.columns.last_updated":"Last Updated","roles.columns.actions":"Actions","roles.create.title":"Create Role","roles.create.description":"Create a new role.","roles.edit.title":"Edit Role","roles.edit.description":"Edit an existing role.","roles.fields.name":"Name","roles.fields.guard_name":"Guard Name","roles.fields.is_default":"Default","roles.fields.created_at":"Created At","roles.fields.updated_at":"Updated At","roles.fields.deleted_at":"Deleted At","roles.fields.permissions":"Permissions","users.title":"Users Management","users.description":"Manage application users.","users.actions.title":"Actions","users.actions.create":"Create User","users.actions.search":"Search Users...","users.actions.reload":"Reload","users.actions.edit":"Edit","users.actions.delete":"Delete","users.actions.block":"Block","users.actions.no_selected":"No users selected","users.actions.block_confirmation":"Are you sure you want to block selected users?","users.actions.block_confirm":"Yes, block them!","users.actions.cancel":"No, cancel","users.actions.block_success":"Selected users blocked successfully!","users.actions.block_error":"Failed to block :names! Please try again later!","users.actions.delete_confirmation":"Are you sure you want to delete selected users?","users.actions.delete_confirm":"Yes, delete them!","users.actions.delete_success":"Selected users deleted successfully!","users.actions.delete_error":"Failed to delete :names! Please try again later!","users.actions.remove_avatar":"Remove Avatar","users.actions.cancel_avatar":"Cancel","users.actions.change_avatar":"Change Avatar","users.actions.form_invalid":"Please fill in all required fields!","users.actions.create_success":"User :name created successfully!","users.actions.view_user_details":"View User Details","users.actions.details":"Details","users.actions.yes":"Yes","users.actions.no":"No","users.actions.connected_accounts":"Connected Accounts","users.actions.connected_accounts_help":"Connected accounts. e.g. facebook, google, twitter","users.actions.google_description":"Google LLC is an American multinational corporation and technology company.","users.actions.github_description":"GitHub is a web-based hosting service for Git version control.","users.actions.save_changes":"Save Changes","users.actions.information":"Information","users.actions.events_and_logs":"Events & Logs","users.actions.login_history":"Login History","users.actions.sign_out_all_devices":"Sign Out All Devices","users.actions.check_location":"Check Location","users.actions.current_session":"Current Session","users.actions.logged_out":"Logged Out","users.actions.logged_in":"Logged In","users.actions.location":"Location","users.actions.check_location_error":"Session not found or invalid. Please try again!","users.actions.checking_location":"Checking Location...","users.actions.checking_location_confirm":"Yes, check it!","users.actions.check_location_success":"Location checked successfully!","users.actions.as_name":"Autonomous System Name","users.actions.asn":"Autonomous System Number","users.actions.city_name":"City Name","users.actions.country_code":"Country Code","users.actions.country_name":"Country Name","users.actions.latitude":"Latitude","users.actions.longitude":"Longitude","users.actions.map":"Map","users.actions.view_on_map":"View on Map","users.fields.user":"User","users.fields.roles":"Roles","users.fields.username":"Username","users.fields.email":"Email","users.fields.google_id":"Google ID","users.fields.facebook_id":"Facebook ID","users.fields.email_verified_at":"Email Verified At","users.fields.password":"Password","users.fields.last_login_at":"Last Login At","users.fields.is_active":"Active","users.fields.permissions":"Permissions","users.fields.created_at":"Created At","users.fields.updated_at":"Updated At","users.fields.deleted_at":"Deleted At","users.fields.actions":"Actions","users.fields.avatar":"Avatar","users.fields.avatar_hint":"Allowed file types: png, jpg, jpeg. Max file size: 5MB.","users.fields.password_confirmation":"Confirm Password","users.fields.account_id":"Account ID","users.fields.ip_address":"IP Address","users.fields.browser":"Browser","users.fields.platform":"Platform","users.fields.event":"Event","users.fields.time":"Time"}};