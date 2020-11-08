<?php
extract( shortcode_atts( array(
	'css'   => ''
), $atts ) );

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

stm_module_styles('searchbox');
 
?>

<div class="stm_searchbox <?php echo esc_attr($css_class); ?>">
    <form action="<?php echo esc_url(STM_LMS_Course::courses_page_url()); ?>">
		<div class="row">
			<div class="col-md-5">
			<select class="form-control">
				<option value="">اختر الجامعة</option>
                <option value="1">جامعة أم القرى</option>
                <option value="2">الجامعة الإسلامية</option>
                <option value="3">جامعة الإمام محمد بن سعود الإسلامية</option>
				<option value="4">جامعة الملك عبد العزيز</option>
                <option value="5">جامعة الملك سعود</option>
                <option value="6">جامعة الملك فهد للبترول والمعادن</option>
				<option value="7">جامعة نايف العربية للعلوم الأمنية</option>
                <option value="8">جامعة الملك فيصل</option>
                <option value="9">جامعة الملك خالد</option>
				<option value="10">جامعة القصيم</option>
                <option value="11">جامعة طيبة</option>
                <option value="12">جامعة الطائف</option>
				<option value="13">جامعة حائل</option>
                <option value="14">جامعة جازان</option>
                <option value="15">جامعة الجوف</option>
				<option value="16">جامعة الباحة</option>
                <option value="17">جامعة تبوك</option>
                <option value="18">جامعة نجران</option>
				<option value="19">جامعة الحدود الشمالية</option>
                <option value="21">جامعة الأميرة نورة بنت عبد الرحمن</option>
                <option value="22">جامعة الملك سعود بن عبد العزيز للعلوم الصحية</option>
				<option value="23">جامعة الإمام عبد الرحمن بن فيصل</option>
                <option value="24">جامعة الملك عبد الله للعلوم والتقنية</option>
                <option value="25">جامعة الأمير سطام بن عبد العزيز</option>
				<option value="26">جامعة شقراء</option>
                <option value="27">جامعة المجمعة</option>
                <option value="28">الجامعة السعودية الالكترونية</option>
				<option value="29">جامعة جدة</option>
                <option value="30">جامعة بيشة</option>
                <option value="31">كلية المدربين التقنيين</option>
				<option value="32">جامعة حفر الباطن</option>
                <option value="33">كلية الجبيل الصناعية</option>
                <option value="34">كلية ينبع الصناعية</option>
				<option value="35">كلية ينبع الجامعية</option>
                <option value="36">كلية الأمير محمد بن سلمان للإدارة وريادة الأعمال</option>
                <option value="37">جامعة رياض العلم</option>
				<option value="38">جامعة المستقبل</option>
                <option value="39">كليات سليمان الراجحي الأهلية</option>
                <option value="40">كلية ابن سينا للعلوم الطبية</option>
				<option value="41">كلية البترجي للعلوم الطبية والتقنية</option>
                <option value="42">كليات الفارابي الأهلية</option>
                <option value="43">كلية المعرفة</option>
				<option value="44">كليات الرياض لطب الاسنان والصيدلة</option>
                <option value="45">جامعة دار الحكمة</option>
                <option value="46">جامعة الأمير مقرن بن عبد العزيز</option>
				<option value="47">جامعة دار العلوم</option>
                <option value="48">جامعة الأمير سلطان</option>
                <option value="49">جامعة عفت الأهلية</option>
				<option value="50">الجامعة العربية المفتوحة</option>
                <option value="51">جامعة اليمامة</option>
                <option value="52">جامعة الأمير فهد بن سلطان</option>
				<option value="53">جامعة الأمير محمد بن فهد</option>
                <option value="54">جامعة الأعمال والتكنولوجيا</option>
                <option value="55">جامعة الفيصل</option>
				<option value="56">كلية جدة العالمية</option>
                <option value="57">كليات الريان الأهلية</option>
				<option value="58">الأكاديمية السعودية للطيران المدني</option>
                <option value="59">أكاديمية الأمير سلطان لعلوم الطيران</option>
				<option value="60">كلية الملك عبد العزيز الحربية</option>
                <option value="61">كلية الملك فهد الأمنية</option>
				<option value="62">كلية الملك فيصل الجوية</option>
                <option value="63">كلية الملك خالد العسكرية</option>
				<option value="64">كلية الملك فهد البحرية</option>
                <option value="65">كلية الملك عبد الله للدفاع الجوي</option>
				<option value="66">مركز ومدرسة قوة الصواريخ الاستراتيجية</option>
            </select>
			
			</div>
			<div class="col-md-5">
			<input name="search" class="form-control" placeholder="<?php esc_attr_e('Search Courses...', 'masterstudy'); ?>" />
			</div>
			<div class="col-md-2">
			<button type="submit" class="btn btn-block">
            ابحث
        </button>
			</div>
		</div>
        
                                
        
    </form>
</div>
