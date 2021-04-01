/*
 * @Author: Brightness
 * @Date: 2020-12-07 14:58:27
 * @LastEditors: Brightness
 * @LastEditTime: 2020-12-08 18:11:21
 * @Description: 监控报价页面
 */
;
/*获取表单数据 开始*/
function getEntity(form) {
  var result = {};
  $(form).find( "input" ).each( function () {
    var field = $( this ).attr( "name" );
    var val = null;
    var type = $( this ).attr( 'type' );
   
    if (type == 'checkbox' ) {
      let checked = $(this).prop('checked');
      if(checked){
        val = $( this ).val();
      }
      
    } else if (type == 'radio') {
      let checked = $(this).prop('checked');
      if(checked){
        val = $( this ).val();
      }
    } else {
      val = $( this ).val();
    }
    // 获取单个属性的值,并扩展到result对象里面
    if(val != null && val != ''){
      getField(field.split( '.' ), val, result);
    }
  });
  return result;
}

function getField(fieldNames, value, result) {
 if (fieldNames.length > 1) {
   for ( var i = 0; i < fieldNames.length - 1; i++) {
     if (result[fieldNames[i]] == undefined) {
       result[fieldNames[i]] = {}
     }
     result = result[fieldNames[i]];
   }
   result[fieldNames[fieldNames.length - 1]] = value;
 } else {
   result[fieldNames[0]] = value;
 }
}
/*获取表单数据 结束*/

/**生成接口 */
function createLink(api,action){
  return "http://gzhaolang.gicp.net:38081/PiRelease/public/index.php?service="+api+"."+action; 
}

/**ajax request */
function ajaxRequest(api,action,data,successCallBack,type='post'){
  $.ajax({
    type: type,
    url: createLink(api,action),
    data: data,
    success: function (response) {
      let json = JSON.parse(response);
      if(json.ret != 200){
        $.alert(json.msg,'警告');
        return;
      }
      
      if(json.data.code != 0 ){
        $.alert(json.data.errmsg);
        return ;
      }
      
      let res = json.data.result;
      successCallBack&&successCallBack(res);
      
    },
    error:function(xml){
      $.toast(xml.responseText, "forbidden");
    }
  });
}
var mySwiper = new Swiper ('.swiper-container', {
    // direction: 'vertical', // 垂直切换选项
    loop: false, // 循环模式选项
    
    // 如果需要分页器
    // pagination: {
    //   el: '.swiper-pagination',
    // },
    
    // 如果需要前进后退按钮
    // navigation: {
    //   nextEl: '.swiper-button-next',
    //   prevEl: '.swiper-button-prev',
    // },
    
    // 如果需要滚动条
    // scrollbar: {
    //   el: '.swiper-scrollbar',
    // },
  })  ;      

  $('.swiper-next1').click(function(){
    let form = $(this).parent('form');
    let data = getEntity(form);
    ajaxRequest('monitor','createCustomer',data,function(res){
      $('.customerId').val(res.customerId);
      mySwiper.slideNext();
    })

  });

  $('.swiper-next2').click(function(){
    let form = $(this).parent('form');
    let data = getEntity(form);
    ajaxRequest('monitor','createOfferParam',data,function(res){
      console.log(res);
      // $('.offerId').val(res.offerId);
      // mySwiper.slideNext();
    })

  });

  $('.swiper-next3').click(function(){
    let form = $(this).parent('form');
    let data = getEntity(form);
    ajaxRequest('monitor','createOfferScene',data,function(res){
      mySwiper.slideNext();
    })

  });

  $('.swiper-finish').click(function () {  
    let form = $(this).parent('form');
    let data = getEntity(form);
    ajaxRequest('monitor','createOfferBusiness',data,function(res){
      $.alert("已收到您的报价需求，我们会尽快与您联系。如需帮助请联系020-83275039");
    })
  });

  $('.swiper-next').click(function(){
   
    mySwiper.slideNext();

  });
   

  $('.swiper-prev').click(function(){
    mySwiper.slidePrev();
  });
  mySwiper.slideNext();
 