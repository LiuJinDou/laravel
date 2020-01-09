/* automatically generated by JSCoverage - do not edit */
try {
  if (typeof top === 'object' && top !== null && typeof top.opener === 'object' && top.opener !== null) {
    // this is a browser window that was opened from another window

    if (! top.opener._$jscoverage) {
      top.opener._$jscoverage = {};
    }
  }
}
catch (e) {}

try {
  if (typeof top === 'object' && top !== null) {
    // this is a browser window

    try {
      if (typeof top.opener === 'object' && top.opener !== null && top.opener._$jscoverage) {
        top._$jscoverage = top.opener._$jscoverage;
      }
    }
    catch (e) {}

    if (! top._$jscoverage) {
      top._$jscoverage = {};
    }
  }
}
catch (e) {}

try {
  if (typeof top === 'object' && top !== null && top._$jscoverage) {
    _$jscoverage = top._$jscoverage;
  }
}
catch (e) {}
if (typeof _$jscoverage !== 'object') {
  _$jscoverage = {};
}
if (! _$jscoverage['ui/menubutton.js']) {
  _$jscoverage['ui/menubutton.js'] = [];
  _$jscoverage['ui/menubutton.js'][5] = 0;
  _$jscoverage['ui/menubutton.js'][6] = 0;
  _$jscoverage['ui/menubutton.js'][10] = 0;
  _$jscoverage['ui/menubutton.js'][11] = 0;
  _$jscoverage['ui/menubutton.js'][13] = 0;
  _$jscoverage['ui/menubutton.js'][15] = 0;
  _$jscoverage['ui/menubutton.js'][16] = 0;
  _$jscoverage['ui/menubutton.js'][17] = 0;
  _$jscoverage['ui/menubutton.js'][22] = 0;
  _$jscoverage['ui/menubutton.js'][23] = 0;
  _$jscoverage['ui/menubutton.js'][24] = 0;
  _$jscoverage['ui/menubutton.js'][25] = 0;
  _$jscoverage['ui/menubutton.js'][26] = 0;
  _$jscoverage['ui/menubutton.js'][27] = 0;
  _$jscoverage['ui/menubutton.js'][28] = 0;
  _$jscoverage['ui/menubutton.js'][32] = 0;
  _$jscoverage['ui/menubutton.js'][35] = 0;
  _$jscoverage['ui/menubutton.js'][39] = 0;
}
_$jscoverage['ui/menubutton.js'].source = ["<span class=\"c\">///import core</span>","<span class=\"c\">///import uicore</span>","<span class=\"c\">///import ui/menu.js</span>","<span class=\"c\">///import ui/splitbutton.js</span>","<span class=\"k\">(</span><span class=\"k\">function</span> <span class=\"k\">()</span><span class=\"k\">{</span>","    <span class=\"k\">var</span> utils <span class=\"k\">=</span> baidu<span class=\"k\">.</span>editor<span class=\"k\">.</span>utils<span class=\"k\">,</span>","        Menu <span class=\"k\">=</span> baidu<span class=\"k\">.</span>editor<span class=\"k\">.</span>ui<span class=\"k\">.</span>Menu<span class=\"k\">,</span>","        SplitButton <span class=\"k\">=</span> baidu<span class=\"k\">.</span>editor<span class=\"k\">.</span>ui<span class=\"k\">.</span>SplitButton<span class=\"k\">,</span>","        MenuButton <span class=\"k\">=</span> baidu<span class=\"k\">.</span>editor<span class=\"k\">.</span>ui<span class=\"k\">.</span>MenuButton <span class=\"k\">=</span> <span class=\"k\">function</span> <span class=\"k\">(</span>options<span class=\"k\">)</span><span class=\"k\">{</span>","            <span class=\"k\">this</span><span class=\"k\">.</span>initOptions<span class=\"k\">(</span>options<span class=\"k\">);</span>","            <span class=\"k\">this</span><span class=\"k\">.</span>initMenuButton<span class=\"k\">();</span>","        <span class=\"k\">}</span><span class=\"k\">;</span>","    MenuButton<span class=\"k\">.</span>prototype <span class=\"k\">=</span> <span class=\"k\">{</span>","        initMenuButton<span class=\"k\">:</span> <span class=\"k\">function</span> <span class=\"k\">()</span><span class=\"k\">{</span>","            <span class=\"k\">var</span> me <span class=\"k\">=</span> <span class=\"k\">this</span><span class=\"k\">;</span>","            <span class=\"k\">this</span><span class=\"k\">.</span>uiName <span class=\"k\">=</span> <span class=\"s\">\"menubutton\"</span><span class=\"k\">;</span>","            <span class=\"k\">this</span><span class=\"k\">.</span>popup <span class=\"k\">=</span> <span class=\"k\">new</span> Menu<span class=\"k\">(</span><span class=\"k\">{</span>","                items<span class=\"k\">:</span> me<span class=\"k\">.</span>items<span class=\"k\">,</span>","                className<span class=\"k\">:</span> me<span class=\"k\">.</span>className<span class=\"k\">,</span>","                editor<span class=\"k\">:</span>me<span class=\"k\">.</span>editor","            <span class=\"k\">}</span><span class=\"k\">);</span>","            <span class=\"k\">this</span><span class=\"k\">.</span>popup<span class=\"k\">.</span>addListener<span class=\"k\">(</span><span class=\"s\">'show'</span><span class=\"k\">,</span> <span class=\"k\">function</span> <span class=\"k\">()</span><span class=\"k\">{</span>","                <span class=\"k\">var</span> list <span class=\"k\">=</span> <span class=\"k\">this</span><span class=\"k\">;</span>","                <span class=\"k\">for</span> <span class=\"k\">(</span><span class=\"k\">var</span> i<span class=\"k\">=</span><span class=\"s\">0</span><span class=\"k\">;</span> i<span class=\"k\">&lt;</span>list<span class=\"k\">.</span>items<span class=\"k\">.</span>length<span class=\"k\">;</span> i<span class=\"k\">++)</span> <span class=\"k\">{</span>","                    list<span class=\"k\">.</span>items<span class=\"k\">[</span>i<span class=\"k\">].</span>removeState<span class=\"k\">(</span><span class=\"s\">'checked'</span><span class=\"k\">);</span>","                    <span class=\"k\">if</span> <span class=\"k\">(</span>list<span class=\"k\">.</span>items<span class=\"k\">[</span>i<span class=\"k\">].</span>value <span class=\"k\">==</span> me<span class=\"k\">.</span>_value<span class=\"k\">)</span> <span class=\"k\">{</span>","                        list<span class=\"k\">.</span>items<span class=\"k\">[</span>i<span class=\"k\">].</span>addState<span class=\"k\">(</span><span class=\"s\">'checked'</span><span class=\"k\">);</span>","                        <span class=\"k\">this</span><span class=\"k\">.</span>value <span class=\"k\">=</span> me<span class=\"k\">.</span>_value<span class=\"k\">;</span>","                    <span class=\"k\">}</span>","                <span class=\"k\">}</span>","            <span class=\"k\">}</span><span class=\"k\">);</span>","            <span class=\"k\">this</span><span class=\"k\">.</span>initSplitButton<span class=\"k\">();</span>","        <span class=\"k\">}</span><span class=\"k\">,</span>","        setValue <span class=\"k\">:</span> <span class=\"k\">function</span><span class=\"k\">(</span>value<span class=\"k\">)</span><span class=\"k\">{</span>","            <span class=\"k\">this</span><span class=\"k\">.</span>_value <span class=\"k\">=</span> value<span class=\"k\">;</span>","        <span class=\"k\">}</span>","        ","    <span class=\"k\">}</span><span class=\"k\">;</span>","    utils<span class=\"k\">.</span>inherits<span class=\"k\">(</span>MenuButton<span class=\"k\">,</span> SplitButton<span class=\"k\">);</span>","<span class=\"k\">}</span><span class=\"k\">)();</span>"];
_$jscoverage['ui/menubutton.js'][5]++;
(function () {
  _$jscoverage['ui/menubutton.js'][6]++;
  var utils = baidu.editor.utils, Menu = baidu.editor.ui.Menu, SplitButton = baidu.editor.ui.SplitButton, MenuButton = (baidu.editor.ui.MenuButton = (function (options) {
  _$jscoverage['ui/menubutton.js'][10]++;
  this.initOptions(options);
  _$jscoverage['ui/menubutton.js'][11]++;
  this.initMenuButton();
}));
  _$jscoverage['ui/menubutton.js'][13]++;
  MenuButton.prototype = {initMenuButton: (function () {
  _$jscoverage['ui/menubutton.js'][15]++;
  var me = this;
  _$jscoverage['ui/menubutton.js'][16]++;
  this.uiName = "menubutton";
  _$jscoverage['ui/menubutton.js'][17]++;
  this.popup = new Menu({items: me.items, className: me.className, editor: me.editor});
  _$jscoverage['ui/menubutton.js'][22]++;
  this.popup.addListener("show", (function () {
  _$jscoverage['ui/menubutton.js'][23]++;
  var list = this;
  _$jscoverage['ui/menubutton.js'][24]++;
  for (var i = 0; (i < list.items.length); (i++)) {
    _$jscoverage['ui/menubutton.js'][25]++;
    list.items[i].removeState("checked");
    _$jscoverage['ui/menubutton.js'][26]++;
    if ((list.items[i].value == me._value)) {
      _$jscoverage['ui/menubutton.js'][27]++;
      list.items[i].addState("checked");
      _$jscoverage['ui/menubutton.js'][28]++;
      this.value = me._value;
    }
}
}));
  _$jscoverage['ui/menubutton.js'][32]++;
  this.initSplitButton();
}), setValue: (function (value) {
  _$jscoverage['ui/menubutton.js'][35]++;
  this._value = value;
})};
  _$jscoverage['ui/menubutton.js'][39]++;
  utils.inherits(MenuButton, SplitButton);
})();
