# Wujin Sushi WordPress 主题

这个仓库现在包含一个可用的 WordPress 主题，以及用于本地运行网站的 Docker 配置。

## 包含内容

- `wujin-sushi-theme/`：实际的 WordPress 主题
- `docker-compose.yml`：用于本地开发的 WordPress、MariaDB 和 phpMyAdmin 环境
- `website_analysis.html`：原始线上网站的参考快照

## 本地启动

1. 运行 `docker compose up -d`
2. 打开 `http://localhost:8088`
3. 完成 WordPress 安装向导
4. 进入 `Appearance > Themes`，启用 `Wujin Sushi` 主题

phpMyAdmin 可通过 `http://localhost:8089` 访问。

## 可在 WordPress 后台编辑的内容

- 首页主视觉文字、联系方式、营业时间、按钮链接：`Appearance > Customize > Restaurant Settings`
- 首页主视觉图片、关于区图片、图库图片：`Appearance > Customize > Restaurant Settings`
- 菜单分类：`Menu Items > Menu Categories`
- 菜品内容和价格：`Menu Items`
- 页脚和主导航：`Appearance > Menus`
- 博客文章和普通页面：使用 WordPress 标准内容类型

## 启用主题后的建议步骤

1. 替换 `wujin-sushi-theme/assets/images/logo.png` 中的默认 logo，或在自定义器中设置自定义 logo
2. 在 `Appearance > Customize > Restaurant Settings` 上传你自己的首页图片
3. 创建真实的 `Menu Item` 菜品条目，并设置特色图片、价格、标签和分类
4. 将预订和点餐按钮链接指向真实的预订页面和结账页面
5. 如果需要购物车和结账功能，请安装 WooCommerce

## 说明

- 这个主题不依赖 WooCommerce 也可以运行；如果安装了 WooCommerce，页头会显示购物车链接。
- 首页使用真实的自定义文章类型来展示菜品，而不是写死的模拟卡片。
