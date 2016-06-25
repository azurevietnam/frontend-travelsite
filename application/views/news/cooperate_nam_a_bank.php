<style>
    .asia-tour { border-top: 10px solid #FE6C00; position: relative; height: 533px }
    .world-tour { border-top: 10px solid #FF7510; position: relative; height: 669px }
    .item { background-color: #fff; padding: 15px 0; font-size: 14px; width: 100%; display: block; clear: both; overflow: hidden; }
    .item ul { list-style: none; float: left; padding-left: 10px }
    .item img { float: left; }
    .item a.item-name { font-size: 18px; color: #0138C6; font-weight: bold; font-style: italic; }
    .origin-price { font-size: 20px; text-decoration: line-through; font-weight: bold; }
    .price { color: #F60403; font-weight: bold; font-size: 20px; margin-left: 5px }
    .unit { color: #254ECC; font-size: 18px; }
    .row-pink { background-color: #FDE1EF; }
    .btn-book-now { padding: 2px 12px; margin: -5px 0 0 10px }
    .asia-tour-bg { left: 0; position: absolute;top: 0; z-index: 10; }
    .pro-code { background: url('/media/news/go_out_together/Code-Enter-Bkg.png') no-repeat; background-size: 100%; color: #fff; position: absolute; right: 0; top: 0;  }
    .pro-code .text { padding: 0 10px 4px 30px; font-size: 16px; margin-top: -8px }
    .pro-code label { font-weight: bold; font-size: 24px }
    
    .halong-cruises { background-color: #306297; overflow: hidden; padding: 15px 40px 60px }
    .halong-cruises h2{ 
        color: #FF4F03; margin: 0 0 10px; display: block; clear: both; padding-bottom: 10px; font-weight:bold;
        text-shadow: -1px 0 #ffffff, 0 1px #ffffff, 1px 0 #ffffff, 0 -1px #ffffff; }
    .halong-cruises a { display: inline-block; position: relative; background-color: #fff; border: 6px solid #fff; border-width: 10px 5px }
    .book-now { bottom: -50px; left: 0; position: absolute; text-align: center; width: 100%; }
    
    .term-condition { background-color: #DBDBDB; overflow: hidden; padding: 10px 40px; margin-bottom: 20px }
    .term-condition ul { padding-left: 20px; font-size: 13px }
    .term-condition ul li { margin-bottom: 5px }
</style>
<div class="container">
	<img class="img-responsive" alt="Hợp tác ngân hàng Nam Á" src="<?=get_static_resources('media/news/nam_a_bank/hop-tac-nam-a-header.jpg')?>">
    <div class="asia-tour">
        <div class="pro-code"><div class="text">Nhập mã <label>NAMA20</label> để nhận ưu đãi</div></div>
        <div class="row-pink item">
            <a href="<?=site_url('tour/thai-lan-hanh-trinh-kham-pha-114.html')?>">
                <img style="padding-left: 394px" src="<?=get_static_resources('media/news/nam_a_bank/Thai-Lan.png')?>">
            </a>
            <ul>
                <li>
                    <a class="item-name" href="<?=site_url('tour/thai-lan-hanh-trinh-kham-pha-114.html')?>">
                        Hành trình Thái Lan
                    </a>
                </li>
                <li>
                    Giá gốc <span class="origin-price">6.600.000</span>
                </li>
                <li>
                    Nhập mã để được giảm thêm<span class="price">600.000<sup>đ</sup></span>
                    <a href="<?=site_url('tour/thai-lan-hanh-trinh-kham-pha-114.html')?>" class="btn btn-bpv btn-book-now">Đặt ngay</a>
                </li>
            </ul>
        </div>
        <div class="item">
            <a href="<?=site_url('tour/singapore-malaysia-hanh-trinh-cu-trai-nghiem-moi-141.html')?>">
                <img style="padding-left: 414px" src="<?=get_static_resources('media/news/nam_a_bank/Singapore.png')?>">
            </a>
            <ul>
                <li>
                    <a class="item-name" href="<?=site_url('tour/singapore-malaysia-hanh-trinh-cu-trai-nghiem-moi-141.html')?>">
                        Trải nghiệm Singapore
                    </a>
                </li>
                <li>
                    Giá gốc <span class="origin-price">11.100.000</span>
                </li>
                <li>
                    Nhập mã để được giảm thêm<span class="price">400.000<sup>đ</sup></span>
                    <a href="<?=site_url('tour/singapore-malaysia-hanh-trinh-cu-trai-nghiem-moi-141.html')?>" class="btn btn-bpv btn-book-now">Đặt ngay</a>
                </li>
            </ul>
        </div>
        <div class="row-pink item">
            <a href="<?=site_url('tour/han-quoc-seoul-lottle-world-dao-nami-hoc-lam-kim-chi-172.html')?>">
                <img style="padding-left: 434px" src="<?=get_static_resources('media/news/nam_a_bank/Han-Quoc.png')?>">
            </a>
            <ul>
                <li>
                    <a class="item-name" href="<?=site_url('tour/han-quoc-seoul-lottle-world-dao-nami-hoc-lam-kim-chi-172.html')?>">
                        Khám phá xứ sở Kim chi Hàn Quốc
                    </a>
                </li>
                <li>
                    Giá gốc <span class="origin-price">14.500.000</span>
                </li>
                <li>
                    Nhập mã để được giảm thêm<span class="price">700.000<sup>đ</sup></span>
                    <a href="<?=site_url('tour/han-quoc-seoul-lottle-world-dao-nami-hoc-lam-kim-chi-172.html')?>" class="btn btn-bpv btn-book-now">Đặt ngay</a>
                </li>
            </ul>
        </div>
        <div class="item">
            <a href="<?=site_url('tour/nhat-ban-tokyo-nui-phu-sy-kawaguchi-65.html')?>">
                <img style="padding-left: 454px" src="<?=get_static_resources('media/news/nam_a_bank/Nhat.png')?>">
            </a>
            <ul>
                <li>
                    <a class="item-name" href="<?=site_url('tour/nhat-ban-tokyo-nui-phu-sy-kawaguchi-65.html')?>">
                        Du lịch Nhật Bản
                    </a>
                </li>
                <li>
                    Giá gốc <span class="origin-price">27.400.000</span>
                </li>
                <li>
                    Nhập mã để được giảm thêm<span class="price">600.000<sup>đ</sup></span>
                    <a href="<?=site_url('tour/nhat-ban-tokyo-nui-phu-sy-kawaguchi-65.html')?>" class="btn btn-bpv btn-book-now">Đặt ngay</a>
                </li>
            </ul>
        </div>
        <img class="asia-tour-bg" src="<?=get_static_resources('/media/news/nam_a_bank/tour-chau-a-bg.png')?>">
    </div>
    <div class="world-tour">
        <div class="item">
            <a href="<?=site_url('tour/tour-uc-7-ngay-melbourne-canberra-sydney-150.html')?>">
                <img style="padding-left: 454px" src="<?=get_static_resources('media/news/nam_a_bank/Uc.png')?>">
            </a>
            <ul>
                <li>
                    <a class="item-name" href="<?=site_url('tour/tour-uc-7-ngay-melbourne-canberra-sydney-150.html')?>">
                        Tour Úc 7 ngày
                    </a>
                </li>
                <li>
                    Giá gốc <span class="origin-price">52.900.000</span>
                </li>
                <li>
                    Nhập mã để được giảm thêm<span class="price">2.500.000<sup>đ</sup></span>
                    <a href="<?=site_url('tour/tour-uc-7-ngay-melbourne-canberra-sydney-150.html')?>" class="btn btn-bpv btn-book-now">Đặt ngay</a>
                </li>
            </ul>
        </div>
        <div class="row-pink item">
            <a href="<?=site_url('tour/chau-au-phap-bi-ha-lan-duc-177.html')?>">
                <img style="padding-left: 434px" src="<?=get_static_resources('media/news/nam_a_bank/Chau-Au.png')?>">
            </a>
            <ul>
                <li>
                    <a class="item-name" href="<?=site_url('tour/chau-au-phap-bi-ha-lan-duc-177.html')?>">
                        9 ngày khám phá Châu Âu
                    </a>
                </li>
                <li>
                    Giá gốc <span class="origin-price">59.500.000</span>
                </li>
                <li>
                    Nhập mã để được giảm thêm<span class="price">2.500.000<sup>đ</sup></span>
                    <a href="<?=site_url('tour/chau-au-phap-bi-ha-lan-duc-177.html')?>" class="btn btn-bpv btn-book-now">Đặt ngay</a>
                </li>
            </ul>
        </div>
        <div class="item">
            <a href="<?=site_url('tour/thu-vang-chau-au-phap-thuy-sy-y-175.html')?>">
                <img style="padding-left: 414px" src="<?=get_static_resources('media/news/nam_a_bank/Italia.png')?>">
            </a>
            <ul>
                <li>
                    <a class="item-name" href="<?=site_url('tour/thu-vang-chau-au-phap-thuy-sy-y-175.html')?>">
                        Khám phá Pháp - Thụy Sỹ - Ý
                    </a>
                </li>
                <li>
                    Giá gốc <span class="origin-price">74.900.000</span>
                </li>
                <li>
                    Nhập mã để được giảm thêm<span class="price">2.500.000<sup>đ</sup></span>
                    <a href="<?=site_url('tour/thu-vang-chau-au-phap-thuy-sy-y-175.html')?>" class="btn btn-bpv btn-book-now">Đặt ngay</a>
                </li>
            </ul>
        </div>
        <div class="row-pink item">
            <a href="<?=site_url('tour/kham-pha-chau-au-mua-la-vang-174.html')?>">
                <img style="padding-left: 394px" src="<?=get_static_resources('media/news/nam_a_bank/Phap.png')?>">
            </a>
            <ul>
                <li>
                    <a class="item-name" href="<?=site_url('tour/kham-pha-chau-au-mua-la-vang-174.html')?>">
                        Tour Châu Âu 13 ngày
                    </a>
                </li>
                <li>
                    Giá gốc <span class="origin-price">85.000.000</span>
                </li>
                <li>
                    Nhập mã để được giảm thêm<span class="price">2.500.000<sup>đ</sup></span>
                    <a href="<?=site_url('tour/kham-pha-chau-au-mua-la-vang-174.html')?>" class="btn btn-bpv btn-book-now">Đặt ngay</a>
                </li>
            </ul>
        </div>
        <div class="item">
            <a href="<?=site_url('tour/newyork-philadelphia-washington-dc-los-angeles-las-vegas-38.html')?>">
                <img style="padding-left: 374px" src="<?=get_static_resources('media/news/nam_a_bank/My.png')?>">
            </a>
            <ul>
                <li>
                    <a class="item-name" href="<?=site_url('tour/newyork-philadelphia-washington-dc-los-angeles-las-vegas-38.html')?>">
                        Châu Mỹ hoa lệ
                    </a>
                </li>
                <li>
                    Giá gốc <span class="origin-price">67.500.000</span>
                </li>
                <li>
                    Nhập mã để được giảm thêm<span class="price">2.500.000<sup>đ</sup></span>
                    <a href="<?=site_url('tour/newyork-philadelphia-washington-dc-los-angeles-las-vegas-38.html')?>" class="btn btn-bpv btn-book-now">Đặt ngay</a>
                </li>
            </ul>
        </div>
        <img class="asia-tour-bg" src="<?=get_static_resources('/media/news/nam_a_bank/tour-au-my-uc-bg.png')?>">
    </div>
    <div class="halong-cruises">
        <h2>Du thuyền Hạ Long</h2>
        <div style="background-color: #fff; text-align: center; border-radius: 10px; margin-top: -12px">
            <a href="<?=site_url('du-thuyen-ha-long/du-thuyen-paloma-8.html')?>">
                <img src="<?=get_static_resources('/media/news/nam_a_bank/Paloma.png')?>">
                <span class="book-now">
                    <img src="<?=get_static_resources('media/news/nam_a_bank/Dat_Ngay_Button.png')?>">
                </span>
            </a>
            <a href="<?=site_url('du-thuyen-ha-long/du-thuyen-emeraude-19.html')?>">
                <img src="<?=get_static_resources('/media/news/nam_a_bank/Emeraude.png')?>">
                <span class="book-now">
                    <img src="<?=get_static_resources('media/news/nam_a_bank/Dat_Ngay_Button.png')?>">
                </span>
            </a>
            <a href="<?=site_url('du-thuyen-ha-long/du-thuyen-pelican-3.html')?>">
                <img src="<?=get_static_resources('/media/news/nam_a_bank/Pelican.png')?>">
                <span class="book-now">
                    <img src="<?=get_static_resources('media/news/nam_a_bank/Dat_Ngay_Button.png')?>">
                </span>
            </a>
            <a class="text-center" href="<?=site_url('du-thuyen-ha-long/du-thuyen-paradise-luxury-1.html')?>">
                <img src="<?=get_static_resources('media/news/nam_a_bank/Paradise.png')?>">
                <span class="book-now">
                    <img src="<?=get_static_resources('media/news/nam_a_bank/Dat_Ngay_Button.png')?>">
                </span>
            </a>
            <a href="<?=site_url('du-thuyen-ha-long/du-thuyen-au-co-2.html')?>">
                <img src="<?=get_static_resources('/media/news/nam_a_bank/Au-Co.png')?>">
                <span class="book-now">
                    <img src="<?=get_static_resources('media/news/nam_a_bank/Dat_Ngay_Button.png')?>">
                </span>
            </a>
        </div>
    </div>
    <div class="term-condition">
    	<h4 style="color: #004D95">
    		<span style="color: #F50206; font-size: 24px; font-weight: bold;">*</span>Điều kiện chương trình:
    	</h4>
    	<ul>
    		<li>Thời hạn hạn đặt thanh toán trước 31/12/2014.</li>
    		<li>Thời hạn sử dụng dịch vụ trước 31/12/2014.</li>
            <li>Không áp dụng vào các dịp lễ tết cùng những chương trình khuyến mãi khác.</li>
    	</ul>
	</div>
</div>