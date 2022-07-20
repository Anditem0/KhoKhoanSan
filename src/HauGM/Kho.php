<?php

namespace HauGM;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\cosole\ConsoleCommandSender;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\item\Item;
use pocketmine\block\Block;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\inventory\CraftItemEvent;
use pocketmine\event\player\PlayerItemConsumeEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerInteractEvent;
use onebone\economyapi\EconomyAPI;
use jojoe77777\FormAPI;
use pocketmine\inventory\Inventory;

class Kho extends PluginBase implements Listener
{
    public Config $stone, $coal, $iron, $gold, $diamond, $emerald, $redstone, $lapis, $quartz, $rs1;

    public function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        @mkdir($this->getDataFolder());
        $this->stone = new Config($this->getDataFolder() . "stone.yml", Config::YAML);
        $this->coal = new Config($this->getDataFolder() . "coal.yml", Config::YAML);
        $this->iron = new Config($this->getDataFolder() . "iron.yml", Config::YAML);
        $this->gold = new Config($this->getDataFolder() . "gold.yml", Config::YAML);
        $this->diamond = new Config($this->getDataFolder() . "diamond.yml", Config::YAML);
        $this->emerald = new Config($this->getDataFolder() . "emerald.yml", Config::YAML);
        $this->redstone = new Config($this->getDataFolder() . "redstone.yml", Config::YAML);
        $this->quartz = new Config($this->getDataFolder() . "quartz.yml", Config::YAML);
        $this->lapis = new Config($this->getDataFolder() . "lapis.yml", Config::YAML);
        $this->rs1 = new Config($this->getDataFolder() . "rs1.yml", Config::YAML);
        

        $this->EconomyAPI = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
    }

    public function onJoin(PlayerJoinEvent $event)
    {
        $player = $event->getPlayer();
        $name = $player->getName();
        //đá
        if (!$this->stone->exists($name)) {
            $this->stone->set($name, 0);
            $this->stone->save();
            //than
        }
        if (!$this->coal->exists($name)) {
            $this->coal->set($name, 0);
            $this->coal->save();
            //sắt
        }
        if (!$this->iron->exists($name)) {
            $this->iron->set($name, 0);
            $this->iron->save();
        }
        //vàng
        if (!$this->gold->exists($name)) {
            $this->gold->set($name, 0);
            $this->gold->save();
        }
        //kim cương
        if (!$this->diamond->exists($name)) {
            $this->diamond->set($name, 0);
            $this->diamond->save();
        }
        //ngọc lục bảo(emerald)
        if (!$this->emerald->exists($name)) {
            $this->emerald->set($name, 0);
            $this->emerald->save();
        }
        //đá đỏ(redstone)
        if (!$this->redstone->exists($name)) {
            $this->redstone->set($name, 0);
            $this->redstone->save();
        }
        //lưu ly(lapis)
        if (!$this->lapis->exists($name)) {
            $this->lapis->set($name, 0);
            $this->lapis->save();
        }
        //thạch anh(quartz)
        if (!$this->quartz->exists($name)) {
            $this->quartz->set($name, 0);
            $this->quartz->save();
        }
       
        //trạng thái
        if (!$this->rs1->exists($name)) {
            $this->rs1->set($name, false);
            $this->rs1->save();
        }
    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool
    {
        if ($cmd->getName() == "kho") {
            $this->KhoForm($sender);
        }
        return true;
    }

    public function KhoForm(Player $sender)
    {
        $formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $formapi->createSimpleForm(function (Player $sender, ?int $data = null) {
            $result = $data;
            if ($result === null) {
                return;
            }
            switch ($result) {
                case 0:
                    $this->ShowKhoFormKS($sender);
                    break;
                case 1:
                    $this->MenuRutKS($sender);
                    break;
                case 2:
                    $this->ManagerForm($sender, "");
                    break;
                case 3:
                    $this->SellForm($sender);
                    break;
            }
        });
        $form->setTitle("§l§c•§9 Giao Diện Kho Đồ §c•");
        $form->setContent("§l§c•§e Tiền của bạn:§a " . $this->EconomyAPI->myMoney($sender));
        $form->addButton("§l§c•§9 Xem Đồ Kho §c•", 0, "textures/ui/xemkho");
        $form->addButton("§l§c•§9 Lấy Đồ Trong Kho §c•", 0, "textures/ui/laydo");
        $form->addButton("§l§c•§9 Quản Lí Tính Năng §c•", 0, "textures/ui/quanlytinhnang");
        $form->addButton("§l§c•§9 Bán Đồ Trong Kho §c•", 0, "textures/ui/bando");
        $form->sendToPlayer($sender);
        return $form;
    }
    

    // Public DMenuRut Code By Nguyễn Công Danh (NCD)
    // Facebook: https://facebook.com/NguyenCongDanh205
    public function MenuRutKS(Player $sender)
    {
        $formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $formapi->createSimpleForm(function (Player $sender, ?int $data = null) {
            $result = $data;
            if ($result === null) {
                $this->KhoForm($sender);
                return;
            }
            switch ($result) {
                case 0:
                    $this->DRutKS($sender, "");
                    break;
                case 1:
                    $this->DRutKs($sender, "");
                    break;
                case 2:
                    $this->DRutKS($sender, "");
                    break;
                case 3:
                    $this->DRutKS($sender, "");
                    break;
                case 4:
                    $this->DRutKS($sender, "");
                    break;
                case 5:
                    $this->DRutKS($sender, "");
                    break;
                case 6:
                    $this->DRutKS($sender, "");
                    break;
                case 7:
                    $this->DRutKS($sender, "");
                    break;
                case 8:
                    $this->DRutKS($sender, "");
                    break;
                case 9:
                    $this->DRutKS($sender, "");
                    break;
                case 10:
                    $this->DRutKS($sender, "");
                    break;
                case 11:
                    $this->DRutKS($sender, "");
                    break;
                case 12:
                    $this->DRutKS($sender, "");
                    break;
                case 13:
                    $this->DRutKS($sender, "");
                    break;
                case 14:
                    $this->DRutKS($sender, "");
                    break;
            }
        });
        $form->setTitle("§l§c•§9 Rút Khoáng Sản §c•");
        $form->setContent("§l§c•§e Chọn khoáng sản bạn cần rút:");
        $form->addButton("§l§c•§9 Đá Cuội §c•\n§l§c•§9 Số lượng: §e" . $this->stone->get($sender->getName()) . " §c•", 0, "textures/ui/da");
        $form->addButton("§l§c•§9 Than §c•\n§l§c•§9 Số lượng: §e" . $this->coal->get($sender->getName()) . " §c•", 0, "textures/ui/than");
        $form->addButton("§l§c•§9 Sắt §c•\n§l§c•§9 Số lượng: §e" . $this->iron->get($sender->getName()) . " §c•", 0, "textures/ui/sat");
        $form->addButton("§l§c•§9 Vàng §c•\n§l§c•§9 Số lượng: §e" . $this->gold->get($sender->getName()) . " §c•", 0, "textures/ui/vang");
        $form->addButton("§l§c•§9 Kim Cương §c•\n§l§c•§9 Số lượng: §e" . $this->diamond->get($sender->getName()) . " §c•", 0, "textures/ui/diamond");
        $form->addButton("§l§c•§9 Ngọc Lục Bảo §c•\n§l§c•§9 Số lượng: §e" . $this->emerald->get($sender->getName()) . " §c•", 0, "textures/ui/ngoclucbao");
        $form->addButton("§l§c•§9 Lưu Ly §c•\n§l§c•§9 Số lượng: §e" . $this->lapis->get($sender->getName()) . " §c•", 0, "textures/ui/luuly");
        $form->addButton("§l§c•§9 Đá Đỏ §c•\n§l§c•§9 Số lượng: §e" . $this->redstone->get($sender->getName()) . " §c•", 0, "textures/ui/dado");
        $form->addButton("§l§c•§9 Thạch anh §c•\n§l§c•§9 Số lượng: §e" . $this->quartz->get($sender->getName()) . " §c•", 0, "textures/ui/ngoclucbao");
        $form->sendToPlayer($sender);
    }
    
    // Public DMenuRut Code By Nguyễn Công Danh (NCD)
    // Facebook: https://facebook.com/NguyenCongDanh205
    public function DRutKS(Player $sender, $danhne)
    {
        $formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $formapi->createCustomForm(function (Player $sender, $data) {
            if ($data == null) {
                $this->KhoForm($sender);
                return true;
            }
            switch ($data[2]) {
                case 0:
                    //đá
                    if ($this->stone->get($sender->getName()) >= $data[1]) {
                        $this->stone->set($sender->getName(), $this->stone->get($sender->getName()) - $data[1]);
                        $this->stone->save();
                        $sender->getInventory()->addItem(ItemFactory::getInstance()->get(4, 0, $data[1]));
                        $this->DRutKS($sender, "§l§c•§a Bạn đã rút đá cuội thành công\n");
                    } else {
                        $this->DRutKS($sender, "§l§c•§c Bạn không đủ đá cuội để rút\n");
                    }
                    break;
                    //than
                case 1:
                    if ($this->coal->get($sender->getName()) >= $data[1]) {
                        $this->coal->set($sender->getName(), $this->coal->get($sender->getName()) - $data[1]);
                        $this->coal->save();
                        $sender->getInventory()->addItem(ItemFactory::getInstance()->get(263, 0, $data[1]));
                        $this->DRutKS($sender, "§l§c•§a Bạn đã rút than thành công\n");
                    } else {
                        $this->DRutKS($sender, "§l§c•§c Bạn không đủ than để rút\n");
                    }
                    break;
                    //sắt
                case 2:
                    if ($this->iron->get($sender->getName()) >= $data[1]) {
                        $this->iron->set($sender->getName(), $this->iron->get($sender->getName()) - $data[1]);
                        $this->iron->save();
                        $sender->getInventory()->addItem(ItemFactory::getInstance()->get(15, 0, $data[1]));
                        $this->DRutKS($sender, "§l§c•§a Bạn đã rút sắt thành công\n");
                    } else {
                        $this->DRutKS($sender, "§l§c•§c Bạn không đủ sắt để rút\n");
                    }
                    break;
                    //vàng
                case 3:
                    if ($this->gold->get($sender->getName()) >= $data[1]) {
                        $this->gold->set($sender->getName(), $this->gold->get($sender->getName()) - $data[1]);
                        $this->gold->save();
                        $sender->getInventory()->addItem(ItemFactory::getInstance()->get(14, 0, $data[1]));
                        $this->DRutKS($sender, "§l§c•§a Bạn đã rút vàng thành công\n");
                    } else {
                        $this->DRutKS($sender, "§l§c•§c Bạn không đủ vàng để rút\n");
                    }
                    break;
                    //kiêm cương
                case 4:
                    if ($this->diamond->get($sender->getName()) >= $data[1]) {
                        $this->diamond->set($sender->getName(), $this->diamond->get($sender->getName()) - $data[1]);
                        $this->diamond->save();
                        $sender->getInventory()->addItem(ItemFactory::getInstance()->get(264, 0, $data[1]));
                        $this->DRutKS($sender, "§l§c•§a Bạn đã rút kim cương thành công\n");
                    } else {
                        $this->DRutKS($sender, "§l§c•§c Bạn không đủ kim cương để rút\n");
                    }
                    break;
                    //ngọc lục bảo
                case 5:
                    if ($this->emerald->get($sender->getName()) >= $data[1]) {
                        $this->emerald->set($sender->getName(), $this->emerald->get($sender->getName()) - $data[1]);
                        $this->emerald->save();
                        $sender->getInventory()->addItem(ItemFactory::getInstance()->get(388, 0, $data[1]));
                        $this->DRutKS($sender, "§l§c•§a Bạn đã rút ngọc lục bảo thành công\n");
                    } else {
                        $this->DRutKS($sender, "§l§c•§c Bạn không đủ ngọc lục bảo để rút\n");
                    }
                    break;
                    //lưu ly
                case 6:
                    if ($this->lapis->get($sender->getName()) >= $data[1]) {
                        $this->lapis->set($sender->getName(), $this->lapis->get($sender->getName()) - $data[1]);
                        $this->lapis->save();
                        $sender->getInventory()->addItem(ItemFactory::getInstance()->get(351, 4, $data[1]));
                        $this->DRutKS($sender, "§l§c•§a Bạn đã rút luli thành công\n");
                    } else {
                        $this->DRutKS($sender, "§l§c•§c Bạn không đủ lưu ly để rút\n");
                    }
                    break;
                    //đé đỏ
                case 7:
                    if ($this->redstone->get($sender->getName()) >= $data[1]) {
                        $this->redstone->set($sender->getName(), $this->redstone->get($sender->getName()) - $data[1]);
                        $this->redstone->save();
                        $sender->getInventory()->addItem(ItemFactory::getInstance()->get(331, 0, $data[1]));
                        $this->DRutKS($sender, "§l§c•§a Bạn đã rút đá đỏ thành công\n");
                    } else {
                        $this->DRutKS($sender, "§l§c•§c Bạn không đủ đá đỏ để rút\n");
                    }
                    break;
                    //thạch anh
                case 8:
                    if ($this->quartz->get($sender->getName()) >= $data[1]) {
                        $this->quartz->set($sender->getName(), $this->quartz->get($sender->getName()) - $data[1]);
                        $this->quartz->save();
                        $sender->getInventory()->addItem(ItemFactory::getInstance()->get(155, 0, $data[1]));
                        $this->DRutKS($sender, "§l§c•§a Bạn đã rút thạch anh thành công\n");
                    } else {
                        $this->DRutKS($sender, "§l§c•§c Bạn không đủ thạch anh để rút\n");
                    }
                    break;
            }
        });
        $form->setTitle("§l§c•§9 Rút Khoáng Sản §c•");
        $form->addLabel($danhne . "§l§c•§a Chọn khoáng sản và số lượng bạn cần rút");
        $form->addSlider("§l§c•§a Số lượng", 1, 64, 1);
        $form->addDropdown("§l§c•§e Chọn khoáng sản", ["§rĐá Cuội", "§rThan", "§rSắt", "§rVàng", "§rKim Cương", "§rNgọc Lục Bảo", "§rLưu Ly", "§rĐá Đỏ", "§rThạch Anh"]);
        $form->sendToPlayer($sender);
    }
   
    
    public function ShowKhoFormKS(Player $sender)
    {
        $formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $formapi->createSimpleForm(function (Player $sender, ?int $data = null) {
            $result = $data;
            if ($result === null) {
                $this->KhoForm($sender);
                return;
            }
            switch ($result) {
                case 0:
                    $this->KhoForm($sender);
                    break;
            }
        });
        $name = $sender->getName();
        $stone = $this->stone->get($name);
        $coal = $this->coal->get($name);
        $iron = $this->iron->get($name);
        $gold = $this->gold->get($name);
        $diamond = $this->diamond->get($name);
        $emerald = $this->emerald->get($name);
        $lapis = $this->lapis->get($name);
        $redstone = $this->redstone->get($name);
        $quartz = $this->quartz->get($name);
        $rs1 = $this->rs1->get($name);
        $form->setTitle("§l§c•§9 Xem Khoáng Sản §c•");
        $form->setContent("§l§e•§c Tổng quan kho của bạn: " . $rs1 . "\n\n§l§c→§e Đá cuội:§a " . $stone . "\n§l§c→§e Than:§a " . $coal . "\n§l§c→§e Sắt:§a " . $iron . "\n§l§c→§e Vàng:§a " . $gold . "\n§l§c→§e Kim cương:§a " . $diamond . "\n§l§c→§e Ngọc Lục Bảo:§a " . $emerald . "\n§l§c→§e Lưu ly:§a " . $lapis . "\n§l§c→§e Đá đỏ:§a " . $redstone . "\n§l§c→§e Thạch anh: §a " . $quartz);
        $form->addButton("§l§c•§9 Thoát §c•", 0, "textures/ui/thoat");
        $form->sendToPlayer($sender);
        return $form;
    }
    

    public function ManagerForm(Player $sender, $danhne)
    {
        $this->FormAPI = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $pir = $this->FormAPI->createCustomForm(function (Player $sender, array $data = null) {

            if ($data == null) {
                $this->KhoForm($sender);
                return true;
            }
            switch ($data[1]) {
                case true:
                    $this->rs1->set($sender->getName(), true);
                    $this->rs1->save();
                    $this->ManagerForm($sender, "§l§c•§a Bạn đã bật tự động vào kho\n");
                    break;
                case false:
                    $this->rs1->set($sender->getName(), false);
                    $this->rs1->save();
                    $this->ManagerForm($sender, "§l§c•§e Bạn đã tắt tự động vào động vào kho\n");
                    break;
            }
        });
        $pir->setTitle("§l§c•§9 Quản Lí Tính Năng §c•");
        $pir->addLabel($danhne . "§l§c•§a Tự động vào kho!");
        $pir->addToggle("§l§c→§e Kéo sang phải để bật.");
        $pir->sendToPlayer($sender);
        return $pir;
    }
    public function SellForm(Player $sender)
    {
        $formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $formapi->createSimpleForm(function (Player $sender, ?int $data = null) {
            $result = $data;
            if ($result === null) {
                $this->KhoForm($sender);
                return;
            }
            switch ($result) {
                case 0:
                    $this->SellFormKS($sender);
                    break;
                case 1:
                    $this->SellFormNS($sender);
                    break;
            }
        });
        $form->setTitle("§l§c• §9Bán Đồ trong kho§c•");
        $form->setContent("§l§c•§eMục Bán Khoáng Sản");
        $form->addButton("§l§c• §9Bán Khoán Sản §c•", 0, "textures/ui/khoansan");
        $form->addButton("§l§c• §9Bán Nông Sản §c•", 0, "textures/ui/nongsan");
        $form->sendToPlayer($sender);
        return $form;
    }
    
    public function SellAllFormKS(Player $sender)
    {
        $this->FormAPI = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $this->FormAPI->createCustomForm(function (Player $sender, array $data = null) {

            if ($data == null) {
                $this->KhoForm($sender);
                return true;
            }
            switch ($data[1]) {
                case true:
                    $name = $sender->getName();
                    $stone = $this->stone->get($name);
                    $coal = $this->coal->get($name);
                    $iron = $this->iron->get($name);
                    $gold = $this->gold->get($name);
                    $diamond = $this->diamond->get($name);
                    $emerald = $this->emerald->get($name);
                    $lapis = $this->lapis->get($name);
                    $redstone = $this->redstone->get($name);
                    $quartz = $this->quartz->get($name);
                    $money = $stone * 1 + $coal * 2 + $iron * 3 + $gold * 4 + $diamond * 6 + $emerald * 7 + $redstone * 1 + $lapis * 2 + $quartz * 2;
                    EconomyAPI::getInstance()->addMoney($sender, $money);
                    $sender->sendMessage("§l§f[§a+§f]§e Cộng §c" . $money . "Xu §eVào Tài Khoản!");
                    $this->stone->set($sender->getName(), 0);
                    $this->stone->save();
                    $this->coal->set($sender->getName(), 0);
                    $this->coal->save();
                    $this->iron->set($sender->getName(), 0);
                    $this->iron->save();
                    $this->gold->set($sender->getName(), 0);
                    $this->gold->save();
                    $this->diamond->set($sender->getName(), 0);
                    $this->diamond->save();
                    $this->emerald->set($sender->getName(), 0);
                    $this->emerald->save();
                    $this->lapis->set($sender->getName(), 0);
                    $this->lapis->save();
                    $this->redstone->set($sender->getName(), 0);
                    $this->redstone->save();
                    $this->quartz->set($sender->getName(), 0);
                    $this->quartz->set($sender->getName(), 0);
                    break;
                case false;
                    break;
            }
        });
        $form->setTitle("§l§c• §9Bán Tất Cả Khoáng Sản §c•");
        $form->addLabel("§l§c•§a Bán tất cả tài nguyên trong kho!");
        $form->addToggle("§l§c→§e Kéo sang phải để bán");
        $form->sendToPlayer($sender);
        return $form;
    }
    
    public function SellEachTypeFormKS(Player $sender)
    {
        $this->FormAPI = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $this->FormAPI->createCustomForm(function (Player $sender, array $data = null) {

            if ($data == null) {
                $this->KhoForm($sender);
                return true;
            }
            switch ($data[2]) {
                case 0:
                    $stone = $this->stone->get($sender->getName());
                    if ($data[1]  <= $stone) {
                        EconomyAPI::getInstance()->addMoney($sender, $data[1] * 1.0);
                        $sender->sendMessage("Bạn đã bán " . $data[1] . " đá cuội được " . $data[1] * 1.0 . " Xu");
                        $this->stone->set($sender->getName(), $stone - $data[1]);
                        $this->stone->save();
                    } else {
                        $sender->sendMessage("Bạn không đủ " . $data[1] . " đá cuội để bán");
                    }
                    break;
                case 1:
                    $coal = $this->coal->get($sender->getName());
                    if ($data[1]  <= $coal) {
                        EconomyAPI::getInstance()->addMoney($sender, $data[1] * 2.0);
                        $sender->sendMessage("Bạn đã bán " . $data[1] . " than được " . $data[1] * 2.0 . " Xu");
                        $this->coal->set($sender->getName(), $coal - $data[1]);
                        $this->coal->save();
                    } else {
                        $sender->sendMessage("Bạn không đủ " . $data[1] . " than để bán");
                    }
                    break;
                case 2:
                    $iron = $this->iron->get($sender->getName());
                    if ($data[1]  <= $iron) {
                        EconomyAPI::getInstance()->addMoney($sender, $data[1] * 3);
                        $sender->sendMessage("Bạn đã bán " . $data[1] . " sắt được " . $data[1] * 3.0 . " Xu");
                        $this->iron->set($sender->getName(), $iron - $data[1]);
                        $this->iron->save();
                    } else {
                        $sender->sendMessage("Bạn không đủ " . $data[1] . " sắt để bán");
                    }
                    break;
                case 3:
                    $gold = $this->gold->get($sender->getName());
                    if ($data[1]  <= $gold) {
                        EconomyAPI::getInstance()->addMoney($sender, $data[1] * 3);
                        $sender->sendMessage("Bạn đã bán " . $data[1] . " vàng được " . $data[1] * 4.0 . " Xu");
                        $this->gold->set($sender->getName(), $gold - $data[1]);
                        $this->gold->save();
                    } else {
                        $sender->sendMessage("Bạn không đủ " . $data[1] . " vàng để bán");
                    }
                    break;
                case 4:
                    $diamond = $this->diamond->get($sender->getName());
                    if ($data[1]  <= $diamond) {
                        EconomyAPI::getInstance()->addMoney($sender, $data[1] * 6);
                        $sender->sendMessage("Bạn đã bán " . $data[1] . " kim cương được " . $data[1] * 6.0 . " Xu");
                        $this->diamond->set($sender->getName(), $diamond - $data[1]);
                        $this->diamond->save();
                    } else {
                        $sender->sendMessage("Bạn không đủ " . $data[1] . " kim cương để bán");
                    }
                    break;
                case 5:
                    $emerald = $this->emerald->get($sender->getName());
                    if ($data[1]  <= $emerald) {
                        EconomyAPI::getInstance()->addMoney($sender, $data[1] * 7);
                        $sender->sendMessage("Bạn đã bán " . $data[1] . " ngọc lục bảo được " . $data[1] * 7.0 . " Xu");
                        $this->emerald->set($sender->getName(), $emerald - $data[1]);
                        $this->emerald->save();
                    } else {
                        $sender->sendMessage("Bạn không đủ " . $data[1] . " ngọc lục bảo để bán");
                    }
                    break;
                case 6:
                    $lapis = $this->lapis->get($sender->getName());
                    if ($data[1]  <= $lapis) {
                        EconomyAPI::getInstance()->addMoney($sender, $data[1] * 2);
                        $sender->sendMessage("Bạn đã bán " . $data[1] . " luli được " . $data[1] * 2.0 . " Xu");
                        $this->lapis->set($sender->getName(), $lapis - $data[1]);
                        $this->lapis->save();
                    } else {
                        $sender->sendMessage("Bạn không đủ " . $data[1] . " luli để bán");
                    }
                    break;
                case 7:
                    $redstone = $this->redstone->get($sender->getName());
                    if ($data[1]  <= $redstone) {
                        EconomyAPI::getInstance()->addMoney($sender, $data[1] * 1);
                        $sender->sendMessage("Bạn đã bán " . $data[1] . " đá đỏ được " . $data[1] * 1.0 . " Xu");
                        $this->redstone->set($sender->getName(), $redstone - $data[1]);
                        $this->redstone->save();
                    } else {
                        $sender->sendMessage("Bạn không đủ " . $data[1] . " đá đỏ để bán");
                    }
                    break;
                case 8:
                    $quartz = $this->quartz->get($sender->getName());
                    if ($data[1]  <= $quartz) {
                        EconomyAPI::getInstance()->addMoney($sender, $data[1] * 2.0);
                        $sender->sendMessage("Bạn đã bán " . $data[1] . " thạch anh  được " . $data[1] * 2.0 . " Xu");
                        $this->quartz->set($sender->getName(), $quartz - $data[1]);
                        $this->quartz->save();
                    } else {
                        $sender->sendMessage("Bạn không đủ " . $data[1] . " đá đỏ để bán");
                    }
                    break;
            }
            // NGUYỄN CÔNG DANH (NCD)
        });
        $form->setTitle("§l§c•§9 Bán Khoáng Sản §c•");
        $form->addLabel("§l§c•§eChọn khoáng sản và số lượng bạn cần bán");
        $form->addSlider("§l§c•§a Số lượng", 1, 64, 1);
        $form->addDropdown("§l§c•§e Chọn khoáng sản", ["§rĐá Cuội", "§rThan", "§rSắt", "§rVàng", "§rKim Cương", "§rNgọc Lục Bảo", "§rLưu Ly", "§rĐá Đỏ", "§rThạch anh"]);
        $form->sendToPlayer($sender);
        return $form;
    }
    
    
    public function onBreak(BlockBreakEvent $event)
    {
        $player = $event->getPlayer();
        $rs1 = $this->rs1->get($player->getName());
        $block = $event->getBlock();
        if ($rs1 == true) {
            foreach ($event->getDrops() as $drop) {
                switch ($block->getId()) {
                    case 4: //Đá Cuội
                        $this->stone->set($player->getName(), $this->stone->get($player->getName()) + 1);
                        $this->stone->save();
                        break;
                    case 16: //Than
                        $this->coal->set($player->getName(), $this->coal->get($player->getName()) + $drop->getCount());
                        $this->coal->save();
                        break;
                    case 15: //Sắt
                        $this->iron->set($player->getName(), $this->iron->get($player->getName()) + 1);
                        $this->iron->save();
                        break;
                    case 14: //Vàng
                        $this->gold->set($player->getName(), $this->gold->get($player->getName()) + 1);
                        $this->gold->save();
                        break;
                    case 56: //Diamond
                        $this->diamond->set($player->getName(), $this->diamond->get($player->getName()) + $drop->getCount());
                        $this->diamond->save();
                        break;
                    case 129: //Emerald
                        $this->emerald->set($player->getName(), $this->emerald->get($player->getName()) + $drop->getCount());
                        $this->emerald->save();
                        break;
                    case 21: //Lapis
                        $this->lapis->set($player->getName(), $this->lapis->get($player->getName()) + $drop->getCount());
                        $this->lapis->save();
                        break;
                    case 73: //Redstone
                        $this->redstone->set($player->getName(), $this->redstone->get($player->getName()) + $drop->getCount());
                        $this->redstone->save();
                        break;
                    case 155: //Quartz
                        $this->quartz->set($player->getName(), $this->quartz->get($player->getName()) + $drop->getCount());
                        $this->quartz->save();
                        break;
                  
                $event->setDrops([]);
            }
        }
    }
}
