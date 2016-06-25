<style>
    .header { background-color: #4B6CBB; width: 100%; height: 230px; position: relative; }
    .cup { position: absolute; top: 0; right: 0 }
    .wonders-vector { position: absolute; bottom: 0; left: 25px }
    .text-title { position: absolute; top: 20px; left: 25px }
    
    .h-border { background-color: #FF9537; }
    .h-border img { margin: 0 0 5px 27px } 
    
    a:hover { text-decoration: none; cursor: pointer; }
    
    .tour-content { 
        background: #EAF2FF url('<?=get_static_resources('/media/news/grateful_week/tour-bg.jpg')?>') no-repeat; 
        height: 450px; 
    }
    .tour-content h2, .cruise-content h2 { color: #F96711; font-weight: bold; font-size: 28px; margin: 0 0 10px 0 }
    .cruise-content { background: #EAF2FF url('/media/news/grateful_week/cruise-bg.jpg') no-repeat; height: 350px; }
    .tour-content, .cruise-content { padding: 15px 25px; overflow: hidden; display: block;  }
    .cruise-content h2 { color: #FB6409; margin-bottom: 15px;
        text-shadow: 2px 0 0 #fff, -2px 0 0 #fff, 0 2px 0 #fff, 0 -2px 0 #fff, 1px 1px #fff, -1px -1px 0 #fff, 1px -1px 0 #fff, -1px 1px 0 #fff;
    }
    
    .cruise-content a { position: relative; display: inline-block; margin-right: 5px }
    .cruise-content a:last-child { margin-right: 0 }
    .book-now { position: absolute; bottom: -33px; left: 0; width: 100%; text-align: center; }
    
    .footer { 
        height: 165px;
        margin-bottom: 40px; 
        background: #27628C url('<?=get_static_resources('/media/news/grateful_week/voucher-banner.png')?>') no-repeat; 
        overflow: hidden;
        position: relative;
    }
    .wonder-footer { position: absolute; right: 0; bottom: 0 }
    .footer-content { padding-left: 500px; color: #fff; }
    .footer-content ul { padding-left: 25px; line-height: 21px; opacity: 0.8 }
    
    .item { background-color: #fff; padding: 10px; font-size: 14px }
    .item a.item-name { font-size: 18px; color: #1A3B70; font-weight: bold; }
    .price { color: #F60403; font-weight: bold; font-size: 20px; margin-left: 5px }
    .unit { color: #254ECC; font-size: 18px; }
    
    .img-responsive {
      display: block;
      max-width: 100%;
      height: auto;
    }
    
    .col-xs-3 { padding-left: 5px; padding-right: 5px }
</style>
<div class="container">
    <div class="header">
        <img class="cup" src="<?=get_static_resources('/media/news/grateful_week/cup-thuong-hieu-noi-tieng.16102014.png')?>">
        <img class="wonders-vector" src="<?=get_static_resources('/media/news/grateful_week/wonders.png')?>">
        <img class="text-title" src="<?=get_static_resources('/media/news/grateful_week/tuan-le-tri-an.png')?>">
    </div>
    <div class="h-border">
        <img src="<?=get_static_resources('/media/news/grateful_week/tang-toi-2-trieu-dong.png')?>">
    </div>
    <div class="tour-content">
        <h2>Tour du lịch</h2>
        <div class="col-xs-3">
            <div class="item">
                <a href="<?=site_url('tour/du-lich-trong-nuoc.html')?>">
                    <img class="img-responsive" src="<?=get_static_resources('/media/news/grateful_week/vietnam.jpg')?>">
                </a>
                <div class="margin-top-10">
                    <a class="item-name"><img src="<?=get_static_resources('/media/news/grateful_week/kham-pha.png')?>">
                    <p>Việt Nam - Vẻ đẹp bất tận</p>
                    </a>
                </div>
                <p><b>Tặng tới</b><span class="price">300.000<sup>đ</sup></span><span class="unit">/1người</span></p>
                <div class="text-center">
                    <a class="btn btn-bpv btn-book-now" href="<?=site_url('tour/du-lich-trong-nuoc.html')?>">Đặt ngay</a>
                </div>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="item">
                <a href="<?=site_url('tour/du-lich-chau-a-346.html')?>">
                    <img class="img-responsive" src="<?=get_static_resources('/media/news/grateful_week/Chau-A.jpg')?>">
                </a>
                <div class="margin-top-10">
                    <a class="item-name"><img src="<?=get_static_resources('/media/news/grateful_week/du-lich.png')?>">
                    <p>Châu Á sắc màu</p>
                    </a>
                </div>
                <p><b>Tặng tới</b><span class="price">500.000<sup>đ</sup></span><span class="unit">/1người</span></p>
                <div class="text-center">
                    <div class="btn btn-bpv btn-book-now">Đặt ngay</div>
                </div>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="item">
                <a href="<?=site_url('tour/du-lich-chau-au-349.html')?>">
                    <img class="img-responsive" src="<?=get_static_resources('/media/news/grateful_week/Chau-Uc.jpg')?>">
                </a>
                <div class="margin-top-10">
                    <a class="item-name"><img src="<?=get_static_resources('/media/news/grateful_week/trai-nghiem.png')?>">
                    <p>Châu Âu, Châu Úc cổ kính</p>
                    </a>
                </div>
                <p><b>Tặng tới</b><span class="price">1.000.000<sup>đ</sup></span><span class="unit">/1người</span></p>
                <div class="text-center">
                    <a class="btn btn-bpv btn-book-now" href="<?=site_url('tour/du-lich-chau-au-349.html')?>">Đặt ngay</a>
                </div>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="item">
                <a href="<?=site_url('tour/du-lich-chau-my-350.html')?>">
                    <img class="img-responsive" src="<?=get_static_resources('/media/news/grateful_week/Chau-My.jpg')?>">
                </a>
                <div class="margin-top-10">
                    <a class="item-name"><img src="<?=get_static_resources('/media/news/grateful_week/thoa-suc-tan-huong.png')?>">
                    <p>Châu Mỹ hoa lệ</p>
                    </a>
                </div>
                <p><b>Tặng tới</b><span class="price">2.000.000<sup>đ</sup></span><span class="unit">/1người</span></p>
                <div class="text-center">
                    <a class="btn btn-bpv btn-book-now" href="<?=site_url('tour/du-lich-chau-my-350.html')?>">Đặt ngay</a>
                </div>
            </div>
        </div>
    </div>
    <div class="cruise-content">
        <h2>Du thuyền Hạ Long - Giảm tới 1.900.000 vnd</h2>
        <div class="text-center">
            <a href="<?=site_url('du-thuyen-ha-long/du-thuyen-paradise-luxury-1.html')?>" class="text-center">
                <img src="<?=get_static_resources('/media/news/grateful_week/Paradise.png')?>">
                <span class="book-now">
                    <img src="<?=get_static_resources('/media/news/grateful_week/btn-book-now.png')?>">
                </span>
            </a>
            <a href="<?=site_url('du-thuyen-ha-long/du-thuyen-au-co-2.html')?>">
                <img src="<?=get_static_resources('/media/news/grateful_week/Au-Co.16102014.png')?>">
                <span class="book-now">
                    <img src="<?=get_static_resources('/media/news/grateful_week/btn-book-now.png')?>">
                </span>
            </a>
            <a href="<?=site_url('du-thuyen-ha-long/du-thuyen-pelican-3.html')?>">
                <img src="<?=get_static_resources('/media/news/grateful_week/Pelican.png')?>">
                <span class="book-now">
                    <img src="<?=get_static_resources('/media/news/grateful_week/btn-book-now.png')?>">
                </span>
            </a>
            <a href="<?=site_url('du-thuyen-ha-long/du-thuyen-paloma-8.html')?>">
                <img src="<?=get_static_resources('/media/news/grateful_week/Paloma.png')?>">
                <span class="book-now">
                    <img src="<?=get_static_resources('/media/news/grateful_week/btn-book-now.png')?>">
                </span>
            </a>
            <a href="<?=site_url('du-thuyen-ha-long/du-thuyen-majestic-17.html')?>">
                <img src="<?=get_static_resources('/media/news/grateful_week/Majestic.png')?>">
                <span class="book-now">
                    <img src="<?=get_static_resources('/media/news/grateful_week/btn-book-now.png')?>">
                </span>
            </a>
        </div>
    </div>
    <div class="footer">
        <div class="footer-content">
            <h4>
    			<span style="color: #F50206; font-size: 24px; font-weight: bold;">*</span><b> Điều kiện chương trình:</b>
    		</h4>
    		<ul>
    			<li>Thời hạn chương trình từ 16/10/2014 tới 31/10/2014</li>
    			<li>Voucher 100.000 VNĐ sẽ được tặng cho khách hàng đặt và thanh toán thành công tại Bestprice trong thời gian diễn ra chương trình.</li>
    			<li>Voucher được áp dụng cho lần đặt sau với các dịch vụ bất kì tại Bestprice.</li>
                <li>Thời hạn sử dụng voucher đến 31/12/2014. Không áp dụng cùng các chương trình khuyến mãi khác.</li>
    		</ul>
        </div>
        <img class="wonder-footer" src="<?=get_static_resources('/media/news/grateful_week/wonder-footer.png')?>">
    </div>
</div>