<?php ob_start(); ?>

    <script>
        Vue.component('stm-image', {
            props: ['image_id'],
            data: function () {
                return {
                    image: {
                        id: '',
                        url: '',
                        file: '',
                        message: '',
                    },
                    loading: false
                }
            },
            mounted: function () {
                var _this = this;
                _this.loading = true;
                _this.$http.get(stm_lms_ajaxurl + '?action=stm_lms_pro_get_image_data&nonce='+ stm_lms_pro_nonces['stm_lms_pro_get_image_data'] + '&image_id=' + _this.image_id).then(function (res) {
                    _this.$set(_this.image, 'id', _this.image_id);
                    _this.$set(_this.image, 'url', res.body);
                    _this.loading = false;
                });
            },
            template: '<?php echo preg_replace(
				"/\r|\n/",
				"",
				addslashes(STM_LMS_Templates::load_lms_template('manage_course/forms/html/image'))
			); ?>',
            methods: {
                loadImage: function () {
                    var _this = this;

                    var fileToUpload = _this.$refs['image-file'].files[0];

                    if (fileToUpload) {

                        var formData = new FormData();
                        _this.loading = true;

                        formData.append('image', fileToUpload);
                        formData.append('action', 'stm_lms_pro_upload_image');
                        formData.append('nonce', stm_lms_pro_nonces['stm_lms_pro_upload_image']);

                        _this.$set(_this.image, 'message', '');
                        _this.$http.post(stm_lms_ajaxurl, formData).then(function (res) {
                            _this.loading = false;
                            if (res['body']['error'] === 'false') {
                                _this.$set(_this.image, 'file', '');
                                _this.$set(_this.image, 'id', res['body']['id']);
                                _this.$set(_this.image, 'url', res['body']['url']);
                            } else {
                                _this.$set(_this.image, 'file', '');
                                _this.$set(_this.image, 'message', res['body']['message']);
                            }
                        });
                    } else {
                        _this.cleanImage();
                    }
                },
                cleanImage() {
                    var _this = this;mana
                    _this.$set(_this.image, 'id', '');
                    _this.$set(_this.image, 'url', '');
                }
            },
            watch: {
                image: {
                    handler: function () {
                        var _this = this;
                        this.$emit('image-changed', _this.image.id);
                    },
                    deep: true
                }
            }
        });

    </script>

<?php wp_add_inline_script('stm-lms-manage_course', str_replace(array('<script>', '</script>'), '', ob_get_clean())); ?>