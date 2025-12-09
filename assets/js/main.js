// Basic JS for copy, print and local save
document.addEventListener('DOMContentLoaded', function(){
  var copyBtn = document.getElementById('copyBtn');
  if(copyBtn){
    copyBtn.addEventListener('click', function(){
      var text = this.getAttribute('data-text') || '';
      navigator.clipboard && navigator.clipboard.writeText(text).then(function(){
        alert('承诺文本已复制到剪贴板。');
      }).catch(function(){
        alert('无法复制，请手动复制。');
      });
    });
  }

  var printBtn = document.getElementById('printBtn');
  if(printBtn){
    printBtn.addEventListener('click', function(){ window.print(); });
  }

  var saveLocal = document.getElementById('saveLocal');
  if(saveLocal){
    saveLocal.addEventListener('click', function(){
      var form = document.getElementById('pledgeForm');
      if(!form) return;
      var data = {};
      Array.from(form.elements).forEach(function(el){ if(el.name){ data[el.name]=el.value; }});
      try{ localStorage.setItem('pledge-draft', JSON.stringify(data)); alert('已保存到本地浏览器。'); }
      catch(e){ alert('保存失败：' + e.message); }
    });
  }

  // Restore draft if present
  var form = document.getElementById('pledgeForm');
  if(form){
    try{
      var draft = JSON.parse(localStorage.getItem('pledge-draft')||'null');
      if(draft){ Object.keys(draft).forEach(function(k){ var el=form.elements[k]; if(el) el.value=draft[k]; }); }
    }catch(e){}
  }
});
