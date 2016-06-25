<style>
    .news-header { position: relative; }
    .main-content { background: #ffffff url('/media/news/go_out_together/minh-di-choi-nhe-bg.jpg') no-repeat; }
    .on-mobile { right: 0; position: absolute; top: 20px; z-index: 10; }
    
    .main-content { padding-bottom: 60px }
    .main-content a { color: #FED032; font-size: 18px; font-weight: bold; }
    .main-content ul { list-style: none; text-align: center; color: #fff; font-size: 13px; padding-left: 0 }
    .price { color: #FF1D07; font-weight: bold; font-size: 20px; margin-left: 5px; 
            text-shadow: -1px 0 #ffffff, 0 1px #ffffff, 1px 0 #ffffff, 0 -1px #ffffff; }
            
     .video { border: 10px solid #F79100; border-radius: 4px; padding: 0 }
     
     .embed-responsive {
        display: block;
        height: 0;
        overflow: hidden;
        padding: 0;
        position: relative;
    }
    .embed-responsive.embed-responsive-16by9 {
        padding-bottom: 56.25%;
    }
     .embed-responsive .embed-responsive-item, .embed-responsive iframe, .embed-responsive embed, .embed-responsive object, .embed-responsive video {
        border: 0 none;
        bottom: 0;
        height: 100%;
        left: 0;
        position: absolute;
        top: 0;
        width: 100%;
    }
    .btn-play-now { position: absolute; left: 50%; top: 6px; margin-left: -100px; cursor: pointer; }
    
    .modal-body { padding-bottom: 0; padding-top: 10px }
    .modal-body h3 { font-size: 13px; color: #F17B23; font-weight: bold; margin-bottom: 5px }
    .modal-title { color: #224694; font-weight: bold; font-size: 24px }
    .btn-check-rate { font-weight: bold; font-size: 14px; padding: 4px 46px }
    .modal-footer { margin-bottom: 10px }
    .modal-content { border-radius: 14px }
    .tips { margin-top: 20px; margin-bottom: 20px; }
    .tips span { font-style: italic; margin-top: 5px; display: block; }
    .tips .col-xs-4 { position: relative; }
    .act-plus, .act-equal { font-size: 20px; font-weight: bold; color: #FE934B; position: absolute; right: 0; top: 50%; margin-right: -7px; margin-top: -10px }

    #howToPlay td { padding: 5px; vertical-align: middle; }
    #howToPlay td .step { font-size: 16px; font-weight: bold; }
    #condition .modal-content { background: #ffffff url('/media/news/go_out_together/the-le-bg.png') no-repeat; background-position: top right;  }
    
    .carousel-control.right, .carousel-control.left { background: none; }
    .carousel-control .glyphicon-chevron-left, .carousel-control .glyphicon-chevron-right {
        width: 48px; height: 48px; margin-top: -24px;
    }
    .carousel-control { opacity: 1 }
    .carousel-control .glyphicon-chevron-right { margin-right: -120px }
    .carousel-control .glyphicon-chevron-left { margin-left: -120px }
    .carousel .item { background-color: #fff; padding: 10px 5px; border-radius: 6px; overflow: hidden; }
    .carousel .item .col-xs-4 { padding: 0 5px }
    .prize { padding-top: 80px; position: relative }
    .prize .award { display: block; height: 262px; line-height: 262px; margin-bottom: 10px }
    .prize .award img { vertical-align: bottom !important; }
</style>
<div class="container">
    <div class="news-header">
    	<img class="img-responsive" alt="Mình cùng đi chơi nhé" src="<?=get_static_resources('media/news/go_out_together/minh-di-choi-nhe-header.jpg')?>">
    	<img class="on-mobile" alt="Mình cùng đi chơi nhé" src="<?=get_static_resources('media/news/go_out_together/Mobile-Img.png')?>">
	</div>
    <div class="main-content">
        <div class="row prize">
            <img class="btn-play-now" data-toggle="modal" data-target="#howToPlay" src="<?=get_static_resources('media/news/go_out_together/Choi-Luon-White-Button.png')?>">
            <div class="col-xs-4">
                <ul class="pull-right">
                    <li class="award"><a href="<?=site_url('du-thuyen-ha-long/du-thuyen-pelican-3.html')?>"><img src="<?=get_static_resources('media/news/go_out_together/Giai-Nhi.png')?>"></a></li>
                    <li><a href="<?=site_url('du-thuyen-ha-long/du-thuyen-pelican-3.html')?>">Du thuyền 4* Pelican</a></li>
                    <li>cho 2 người trị giá <span class="price">6.500.000<sup>đ</sup></span></li>
                </ul>
            </div>
            <div class="col-xs-4 text-center">
                <ul>
                    <li class="award"><a href="<?=site_url('du-thuyen-ha-long/du-thuyen-paradise-luxury-1.html')?>"><img src="<?=get_static_resources('media/news/go_out_together/Giai-Nhat.png')?>"></a></li>
                    <li><a href="<?=site_url('du-thuyen-ha-long/du-thuyen-paradise-luxury-1.html')?>">Du thuyền 5* Paradise Luxury</a></li>
                    <li>cho 2 người trị giá <span class="price">10.200.000<sup>đ</sup></span></li>
                </ul>          
            </div>
            <div class="col-xs-4">
                <ul class="pull-left">
                    <li class="award"><a href="<?=site_url('khach-san/khach-san-paradise-suites-ha-long-98.html')?>"><img src="<?=get_static_resources('media/news/go_out_together/Giai-Ba.png')?>"></a></li>
                    <li><a href="<?=site_url('khach-san/khach-san-paradise-suites-ha-long-98.html')?>">Nghỉ dưỡng tại Paradise Suites 4*</a></li>
                    <li>trị giá <span class="price">1.800.000<sup>đ</sup></span></li>
                </ul>
            </div>
        </div>
        <div class="row text-center" style="padding: 10px 0;">
            <img style="cursor: pointer;" data-toggle="modal" data-target="#condition" src="<?=get_static_resources('media/news/go_out_together/The-Le-Button.png')?>">
        </div>
        <div class="row" style="padding-top: 30px">
            <h2 class="text-center" style="color: #fff; font-weight: bold;">Video</h2>
            <div class="col-xs-offset-3 col-xs-6 video">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="//www.youtube.com/embed/Vo0HYTPPFos" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        </div>
        <div class="row" style="padding-top: 20px">
            <h2 class="text-center" style="color: #fff; font-weight: bold;">Ảnh nổi bật</h2>
        </div>
        <div class="row">
            <div id="carousel-album" class="carousel slide col-xs-10 col-xs-offset-1" data-ride="carousel" data-interval="3000">
             
              <!-- Wrapper for slides -->
              <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <div class="col-xs-4">
                        <img class="img-responsive" src="<?=get_static_resources('media/news/go_out_together/nguyen_diem_my.jpg')?>">
                    </div>
                    <div class="col-xs-4">
                        <img class="img-responsive" src="<?=get_static_resources('media/news/go_out_together/le_quyen.jpg')?>">
                    </div>
                    <div class="col-xs-4">
                        <img class="img-responsive" src="<?=get_static_resources('media/news/go_out_together/nguyen_ngoc_bich.jpg')?>">
                    </div>
                </div>
                <div class="item">
                    <div class="col-xs-4">
                        <img class="img-responsive" src="<?=get_static_resources('media/news/go_out_together/anh_du_thi.jpg')?>">
                    </div>
                    <div class="col-xs-4">
                        <img class="img-responsive" src="<?=get_static_resources('media/news/go_out_together/anh2.jpg')?>">
                    </div>
                    <div class="col-xs-4">
                        <img class="img-responsive" src="<?=get_static_resources('media/news/go_out_together/anh3.jpg')?>">
                    </div>
                </div>
                <div class="item">
                    <div class="col-xs-4">
                        <img class="img-responsive" src="<?=get_static_resources('media/news/go_out_together/anh7.jpg')?>">
                    </div>
                    <div class="col-xs-4">
                        <img class="img-responsive" src="<?=get_static_resources('media/news/go_out_together/anh8.jpg')?>">
                    </div>
                    <div class="col-xs-4">
                        <img class="img-responsive" src="<?=get_static_resources('media/news/go_out_together/anh9.jpg')?>">
                    </div>
                </div>
                <div class="item">
                    <div class="col-xs-4">
                        <img class="img-responsive" src="<?=get_static_resources('media/news/go_out_together/anh4.jpg')?>">
                    </div>
                    <div class="col-xs-4">
                        <img class="img-responsive" src="<?=get_static_resources('media/news/go_out_together/anh5.jpg')?>">
                    </div>
                    <div class="col-xs-4">
                        <img class="img-responsive" src="<?=get_static_resources('media/news/go_out_together/anh6.jpg')?>">
                    </div>
                </div>
              </div>
            
              <!-- Controls -->
              <a class="left carousel-control" href="#carousel-album" role="button" data-slide="prev">
                <img class="glyphicon-chevron-left" src="<?=get_static_resources('media/news/go_out_together/Back-Button.png')?>">
              </a>
              <a class="right carousel-control" href="#carousel-album" role="button" data-slide="next">
                <img class="glyphicon-chevron-right" src="<?=get_static_resources('media/news/go_out_together/Next-Button.png')?>">
              </a>
            </div>
        </div>
        <div class="row text-center" style="padding-top: 20px">
            <a href="https://www.facebook.com/media/set/?set=a.1583242931896922.1073741834.1477389845815565&type=1"><img src="<?=get_static_resources('media/news/go_out_together/Album-Button.png')?>"></a>
        </div>
    </div>
</div>

<!-- How to play modal -->
<div class="modal fade" id="howToPlay" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <h4 class="modal-title">
            Cách chơi
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
        		<img src="<?=get_static_resources('media/news/go_out_together/Close-Button.png')?>">
        	</button>
        </h4>
        <table>
            <tr>
                <td colspan="2">
                    <p>Hoà cùng không khí du lịch mùa cuối năm, BestPrice tưng bừng tổ chức cuộc thi ảnh "Mình đi chơi nhé". 
                    Hãy gửi cho chúng tôi những bức ảnh du lịch của bạn cùng người thân, bạn bè để có cơ hội rinh những chuyến du lịch có giá trị của BestPrice.
                    </p>
                    <ul style="padding-left: 0; list-style: none; line-height: 21px">
                        <li>+ Giải nhất: Chuyến du thuyền <span class="bpv-color-price">Paradise 5*</span> cho 2 người trị giá 10.200.000 vnđ</li>
                        <li>+ Giải nhì: Chuyến du thuyền <span class="bpv-color-price">Pelican 4*</span> cho 2 người trị giá 6.500.000 vnđ</li>
                        <li>+ Giải ba: Nghỉ dưỡng tại khách sạn <span class="bpv-color-price">Hạ Long Paradise Suites 4*</span> trị giá 1.800.000 vnđ</li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;"><img src="<?=get_static_resources('media/news/go_out_together/Camera-Icon.png')?>"></td>
                <td>
                    <p><span class="step">Bước 1</span>: Gửi anh du lịch của bạn cùng người thân hoặc ảnh vẽ ngón tay du lịch ngộ nghĩnh. Sau đó gửi ảnh dự thi vào email: 
                    <a href="mailto:marketing@Bestviettravel.xyz">marketing@Bestviettravel.xyz</a> hoặc gửi qua message 
                    <a href="https://www.facebook.com/BestPricevn">Fanpage Best Price</a> cùng thông tin cá nhân gồm: Tên, Năm sinh, Sđt, Email, Link trang facebook của bạn.</p>
                </td>
            </tr>
            <tr>
                <td><img src="<?=get_static_resources('media/news/go_out_together/Send-Mail-Icon.png')?>"></td>
                <td><span class="step">Bước 2</span>: Sau khi ảnh dự thi của bạn được đăng trên album 
                "<b><a href="https://www.facebook.com/media/set/?set=a.1583242931896922.1073741834.1477389845815565&type=1">Mình đi chơi nhé</a></b>" tại <a href="https://www.facebook.com/BestPricevn">Fanpage Best Price</a>, Best Price sẽ thông báo cho bạn qua email hoặc nhắn tin Facebook</td>
            </tr>
            <tr>
                <td><img src="<?=get_static_resources('media/news/go_out_together/Like-Icon.png')?>"></td>
                <td><span class="step">Bước 3</span>: Hãy kêu gọi bạn bè và người thân của bạn like và share để có cơ hội trúng giải của Bestprice.
                <p class="bpv-color-price">1 Like = 1 điểm<br>1 Share = 2 điểm</p>
                </td>
            </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button data-dismiss="modal" class="btn btn-bpv btn-check-rate" type="button">OK</button>
      </div>
    </div>
  </div>
</div>

<!-- Condition -->
<div class="modal fade" id="condition" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <h4 class="modal-title">
            Thể lệ "Mình đi chơi nhé"
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
    			<img src="<?=get_static_resources('media/news/go_out_together/Close-Button.png')?>">
    		</button>
        </h4>
        <h3>1.Đối tượng</h3>
        <p>Tất cả mọi người</p>
        
        <h3>2. Cách thức tham gia</h3>
        <p>Thời gian thực hiện. Từ ngày 1/12 đến hết 21/12/2014</p>
        
        <p>Bước 1: Gửi anh du lịch của bạn cùng người thân hoặc ảnh vẽ ngón tay du lịch ngộ nghĩnh. Sau đó gửi ảnh dự thi vào email: 
        <a href="mailto:marketing@Bestviettravel.xyz">marketing@Bestviettravel.xyz</a> hoặc gửi qua message 
        <a href="https://www.facebook.com/BestPricevn">Fanpage Best Price</a> cùng thông tin cá nhân gồm: Tên, Sđt, Email, Link trang facebook của bạn.
        </p>
        
        <p>Bước 2: Sau khi ảnh dự thi của bạn được đăng trên album "<b><a href="https://www.facebook.com/media/set/?set=a.1583242931896922.1073741834.1477389845815565&type=1">Mình đi chơi nhé</a></b>" tại <a href="https://www.facebook.com/BestPricevn">Fanpage Best Price</a>, Best Price 
        sẽ thông báo cho bạn qua email hoặc nhắn tin Facebook</p>
        
        <p>Bước 3: Like và share ảnh của bạn để dễ dàng có cơ hội nhận giải nhất.</p>
        
        <h3>3. Cách tính điểm</h3>
        <p class="bpv-color-price">1 Like = 1 điểm<br>1 Share = 2 điểm</p>
        
        <h3>4. Giải thưởng</h3>
        <p>- Giải nhất: Chuyến du thuyền Paradise Luxury 2 ngày 1 đêm  5* cho 2 người trị giá 10.200.000 vnđ dành cho người có số điểm cao nhất tính đến hết 21/12/2014</p>
        <p>- Giải nhì: Chuyến du thuyền Pelican 2 ngày 1 đêm  4* cho 2 người trị giá 6.500.000 vnđ dành cho người có số điểm cao thứ nhì tính đến hết 21/12/2014</p>
        <p>- Giải ba: 1 Đêm nghỉ dưỡng tại khách sạn  Hạ Long Paradise Suites 4* trị giá 1.800.000 vnđ.</p>
        <p>Đặc biệt bất kì người chơi nào tham gia hợp lệ cũng nhận được voucher trị giá 100.000 vnđ từ Best Price. Giải thưởng không được quy đổi 
        thành tiền mặt trong bất kì trường hợp nào, tuy nhiên có thể chuyển nhượng.</p>
        
        <h3>5. Quy định của chương trình</h3>
        <p>- Sản phẩm dự thi thể hiện dưới dạng file ảnh định dạng JPG, PNG hoặc GIF và không quá 3MB, có chiều ngang dưới 1.000 pixel Ảnh có thể chỉnh photoshop, sửa ánh sáng, màu sắc nhưng không được thay đổi về nội dung ảnh, không gắn chữ liên quan tới bất kỳ nhãn hiệu nào, không gắn logo của bất cứ nhãn hiệu nào trong ảnh.</p>
        <p>- Một người có thể tham gia tối đa 3 ảnh, tuy nhiên chỉ lấy kết quả trên bức ảnh có nhiều điểm nhất.</p>
        <p>- Ảnh tham gia chương trình do người tham dự tự chụp và gửi tham dự, ban tổ chức không nhận bài dự thi được sưu tầm từ Internet.</p>
        <p>- Ban tổ chức có quyền từ chối đăng những ảnh không phù hợp với quy chế chương trình hoặc vi phạm thuần phong mỹ tục và các quy định của nhà nước.</p>
        <p>- Người tham gia hoàn toàn chịu trách nhiệm về bản quyền của ảnh tham dự, nếu có tranh chấp, trong vòng 7 ngày, phải gửi thông tin để chứng minh về bản quyền ảnh dự thi. Ảnh vi phạm bản quyền sẽ bị gỡ khỏi trang.</p>
        <p>- Quà tặng không được quy đổi thành tiền mặt trong bất cứ trường hợp nào nhưng có thể được chuyển nhượng.</p>
        <p class="bpv-color-price">- BTC có quyền tạm dừng cuộc thi những bài dự thi có dấu hiệu bất thường, có số like tăng đột biến hoặc các dấu hiện gian lận khác.</p>
        <p class="bpv-color-price">- Người tham gia dự thi không được dùng phần mềm hay bất kì công cụ nào tác động vào tác phẩm để tăng like, nếu phát hiện BTC sẽ huỷ kết quả bài dự thi của thí sinh đó.</p>
        <p class="bpv-color-price">- BTC nghiêm cấm các hành vi gian lận dưới mọi hình thức. Những tấm ảnh dự thi có dấu hiệu gian lận (tạo nick ảo, like ảo, ...) BTC sẽ không trao giải và sẽ loại khỏi kết quả cuối cùng mà không cần báo trước.</p>
        <p class="bpv-color-price">- Tham dự cuộc thi là mặc nhiên chấp nhận mọi quyết định của BTC. Trong mọi trường hợp, quyết định của BTC là quyết định cuối cùng.</p>
        <p class="bpv-color-price">- Thời hạn sử dụng giải thưởng trước 30/6/2015. Người nhận giải trước khi sử dụng dịch vụ phải đăng ký với BestPrice trước 2 tuần.</p>
        <p class="bpv-color-price">- Trong vòng 72 giờ kể từ khi thông báo người thắng cuộc, nếu BestPrice không liên hệ được với người thắng cuộc, giải thưởng sẽ được trao cho người có số điểm cao kế tiếp.</p>
        
        <h3>6. Quyền sử dụng ảnh</h3>
        <p>Ban tổ chức có quyền xuất bản, quảng bá thương mại với ảnh dự thi mà không cần phải báo trước và không cần thêm bất kỳ một chi phí nào, được sử dụng trưng bày, lựa chọn ảnh đăng trên các phương tiện thông tin, ấn phẩm.</p>
      
        <h3>7. Hạn chế trách nhiệm</h3>
        <p>- Ban tổ chức không chịu trách nhiệm về những thông tin khai không đúng của người tham gia cuộc thi.</p>
        <p>- Ban tổ chức không chịu trách nhiệm trong trường hợp cuộc thi bị hủy bỏ hoặc hoãn vì những lý do bất khả kháng, khách quan như bị đánh sập mạng, thiên tai, chiến tranh…</p>
        <p>- Ban tổ chức không chịu trách nhiệm khi ảnh gửi tới chương trình bị hỏng, biến dạng hay thay đổi chất lượng do đường truyền hoặc sự cố mạng Internet.</p>
      </div>
      <div class="modal-footer">
        <button data-dismiss="modal" class="btn btn-bpv btn-check-rate" type="button">OK</button>
      </div>
    </div>
  </div>
</div>

<script>
    setInterval(function(){myTimer()}, 1000);
    
    function myTimer() {
    	var img_red = 'Choi-Luon-Button.png';
        var img_white = 'Choi-Luon-White-Button.png';
        var img_yellow = 'Choi-Luon-Yellow-Button.png';
        var src = $('.btn-play-now').attr('src');
     
        if(src.indexOf(img_white) > -1)
        {
        	src = src.replace(img_white, img_red);
        }
        else if(src.indexOf(img_red) > -1)
        {
        	src = src.replace(img_red, img_yellow);
        }
        else if(src.indexOf(img_yellow) > -1) {
        	src = src.replace(img_yellow, img_white);
        }

        

        $('.btn-play-now').attr('src', src);
    }
</script>