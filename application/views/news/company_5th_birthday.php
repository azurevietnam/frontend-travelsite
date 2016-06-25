<style>
    .tour-block, .hotel-block { position: relative; }
    
    .main-background { background: url('/media/news/bestprice_5h_birthday/Bkg.png') no-repeat; background-size: 100%; }
    .tour-list { margin-top: 70px }
    .tour-list .book-now, .hotel-list .book-now { bottom: -5px }
    .tour-list, .hotel-list { background-color: #DDF0F7; border-radius: 10px; padding: 20px; position: relative; width: 760px }
    .img-1 { position: absolute; left: -340px; top: -130px }
    .img-2 { position: absolute; left: -340px; top: -130px }
    .img-3 { position: absolute; left: -103px; top: -82px }
    .img-4 { position: absolute; left: -4px; top: -90px }
    
    .halong-cruises { overflow: hidden; padding: 40px 40px 60px; margin-top: 30px }
    .halong-cruises h2{ 
        color: #FF4F03; margin: 0 0 10px; display: block; clear: both; padding-bottom: 10px; font-weight:bold;
        text-shadow: -1px 0 #ffffff, 0 1px #ffffff, 1px 0 #ffffff, 0 -1px #ffffff; position: relative; height: 40px }
    .halong-cruises a { display: inline-block; position: relative; background-color: #fff; border: 6px solid #fff; border-width: 10px 5px }
    .book-now { bottom: -50px; left: 0; position: absolute; text-align: center; width: 100%; }
    .img-5 { position: absolute; left: 210px; top: -42px; z-index: 1 }
    
    .term-condition { background-color: #F7F7F7; overflow: hidden; padding: 10px 40px; margin-bottom: 20px }
    .term-condition ul { padding-left: 20px; font-size: 13px }
    .term-condition ul li { margin-bottom: 5px }
</style>
<div class="container">
    <img class="img-responsive" alt="Mừng sinh nhật BestPrice- khuyến mại tới 50%" 
        src="<?=get_static_resources('media/news/bestprice_5h_birthday/bestprice-5h-birthday-header-21-5-15.jpg')?>">
    <div class="main-background">
        <div class="row">
            <div class="col-xs-offset-4 col-xs-8 tour-list">
                <img class="img-1" src="<?=get_static_resources('media/news/bestprice_5h_birthday/Tour-Du-Lich-Imf.png')?>">
                <img class="img-3" src="<?=get_static_resources('media/news/bestprice_5h_birthday/Giam-Toi-500k.png')?>">
                <div class="col-xs-4 text-center">
                    <a class="text-center" href="<?=site_url('/tour/nha-trang-da-lat-bien-hen-tinh-yeu-88.html')?>">
                        <img src="<?=get_static_resources('media/news/bestprice_5h_birthday/Nhatrang-Dalat.png')?>">
                        <span class="book-now">
                            <img src="<?=get_static_resources('media/news/bestprice_5h_birthday/Dat-Ngay-Button.png')?>">
                        </span>
                    </a>
                </div>
                <div class="col-xs-4 text-center">
                    <a class="text-center" href="<?=site_url('/tour/ha-noi-da-nang-hue-hoi-an-79.html')?>">
                        <img src="<?=get_static_resources('media/news/bestprice_5h_birthday/Danang-Hue-Hoian.png')?>">
                        <span class="book-now">
                            <img src="<?=get_static_resources('media/news/bestprice_5h_birthday/Dat-Ngay-Button.png')?>">
                        </span>
                    </a>
                </div>
                <div class="col-xs-4 text-center">
                    <a class="text-center" href="<?=site_url('/tour/du-lich-dong-nam-a-74.html')?>">
                        <img src="<?=get_static_resources('media/news/bestprice_5h_birthday/Dong-Nam-A.png')?>">
                        <span class="book-now">
                            <img src="<?=get_static_resources('media/news/bestprice_5h_birthday/Dat-Ngay-Button.png')?>">
                        </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 160px">
            <div class="col-xs-offset-4 col-xs-8 hotel-list">
                <img class="img-2" src="<?=get_static_resources('media/news/bestprice_5h_birthday/KS-Sang-Trong-Img.png')?>">
                <img class="img-4" src="<?=get_static_resources('media/news/bestprice_5h_birthday/Uu-Dai-50.png')?>">
                <div class="col-xs-3">
                    <a class="text-center" href="<?=site_url('/khach-san-phu-quoc-16.html')?>">
                        <img src="<?=get_static_resources('media/news/bestprice_5h_birthday/Phu-Quoc.png')?>">
                        <span class="book-now">
                            <img src="<?=get_static_resources('media/news/bestprice_5h_birthday/Dat-Ngay-Button.png')?>">
                        </span>
                    </a>
                </div>
                <div class="col-xs-3">
                    <a class="text-center" href="<?=site_url('/khach-san-da-nang-4.html')?>">
                        <img src="<?=get_static_resources('media/news/bestprice_5h_birthday/Da-Nang.png')?>">
                        <span class="book-now">
                            <img src="<?=get_static_resources('media/news/bestprice_5h_birthday/Dat-Ngay-Button.png')?>">
                        </span>
                    </a>
                </div>
                <div class="col-xs-3">
                    <a class="text-center" href="<?=site_url('/khach-san-nha-trang-6.html')?>">
                        <img src="<?=get_static_resources('media/news/bestprice_5h_birthday/Nha-Trang.png')?>">
                        <span class="book-now">
                            <img src="<?=get_static_resources('media/news/bestprice_5h_birthday/Dat-Ngay-Button.png')?>">
                        </span>
                    </a>
                </div>
                <div class="col-xs-3">
                    <a class="text-center" href="<?=site_url('/khach-san-phan-thiet-103.html')?>">
                        <img src="<?=get_static_resources('media/news/bestprice_5h_birthday/Phan-Thiet.png')?>">
                        <span class="book-now">
                            <img src="<?=get_static_resources('media/news/bestprice_5h_birthday/Dat-Ngay-Button.png')?>">
                        </span>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="halong-cruises">
            <h2>
                <span style="position: absolute; top: 7px; left: 0; z-index: 2; font-size: 30px">Du thuyền Hạ Long</span>
                <img class="img-5" src="<?=get_static_resources('media/news/bestprice_5h_birthday/Giam-Toi-1t8.png')?>">
            </h2>
            <div style="background-color: #fff; text-align: center; border-radius: 10px; margin-top: -12px">
                <a href="<?=site_url('/du-thuyen-ha-long/tour-du-thuyen-au-co-3-ngay-2-dem-2.html')?>">
                    <img src="<?=get_static_resources('/media/news/bestprice_5h_birthday/Au-Co.png')?>">
                    <span class="book-now">
                        <img src="<?=get_static_resources('media/news/bestprice_5h_birthday/Dat-Ngay-Button-02.png')?>">
                    </span>
                </a>
                <a href="<?=site_url('/du-thuyen-ha-long/tour-du-thuyen-paloma-2-ngay-1-dem-8.html')?>">
                    <img src="<?=get_static_resources('/media/news/bestprice_5h_birthday/Paloma.png')?>">
                    <span class="book-now">
                        <img src="<?=get_static_resources('media/news/bestprice_5h_birthday/Dat-Ngay-Button-02.png')?>">
                    </span>
                </a>
                <a href="<?=site_url('/du-thuyen-ha-long/tour-du-thuyen-pelican-2-ngay-1-dem-6.html')?>">
                    <img src="<?=get_static_resources('/media/news/bestprice_5h_birthday/Pelican.png')?>">
                    <span class="book-now">
                        <img src="<?=get_static_resources('media/news/bestprice_5h_birthday/Dat-Ngay-Button-02.png')?>">
                    </span>
                </a>
                <a href="<?=site_url('/du-thuyen-ha-long/tour-du-thuyen-starlight-2-ngay-1-dem-206.html')?>">
                    <img src="<?=get_static_resources('/media/news/bestprice_5h_birthday/Sealife.png')?>">
                    <span class="book-now">
                        <img src="<?=get_static_resources('media/news/bestprice_5h_birthday/Dat-Ngay-Button-02.png')?>">
                    </span>
                </a>
                <a class="text-center" href="<?=site_url('/du-thuyen-ha-long/tour-du-thuyen-sealife-2-ngay-1-dem-228.html')?>">
                    <img src="<?=get_static_resources('media/news/bestprice_5h_birthday/Starlight.png')?>">
                    <span class="book-now">
                        <img src="<?=get_static_resources('media/news/bestprice_5h_birthday/Dat-Ngay-Button-02.png')?>">
                    </span>
                </a>
            </div>
        </div>
    </div>    
    <div class="term-condition col-xs-12">
    	<h4 style="color: #004D95">
    		<span style="color: #F50206; font-size: 24px; font-weight: bold;">*</span>Điều kiện chương trình:
    	</h4>
    	<ul>
    		<li>Chương trình khuyến mãi kéo dài đến hết 07/06/2015.</li>
    		<li>Thời hạn sử dụng dịch vụ trước 31/08/2015.</li>
            <li>Với khách có mã code đặt biệt, áp dụng tối đa cho 5 người trong đoàn.</li>
    	</ul>
	</div>
</div>