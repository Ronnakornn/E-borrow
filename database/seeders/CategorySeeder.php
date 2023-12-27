<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    use WithoutModelEvents; // ไม่ต้องจับ event ของ model ในการทำ seeder ข้อมูล

    /**
     * จำลองข้อมูล หมวดหมู่สินค้า ในระบบทั้งหมด
     *
     *
     */
    public function run(): void
    {

        $categories = [
            [
                'name' => 'Notebook',
                'description' => 'จำหน่ายสินค้าโน๊ตบุ๊ค (Notebook) โน๊ตบุ๊คทำงาน, โน๊ตบุ๊คเรียน, โน๊ตบุ๊คเกมมิ่ง Gaming Notebook สเปกแรง ราคาดี พร้อมโปรโมชันของแถมอีกมากมาย จากหลากหลายแบรนด์ชั้นนำทั่วโลก อาทิ Microsoft Surface, Acer, Asus, Dell, HP, Lenovo, MSI และแบรนด์อื่นๆ อีกมากมาย ในราคาคุ้มค่าเหมาะกับการใช้งาน ไม่ว่าจะเรียน ทำงาน หรือเล่นเกมก็ลื่นไหล ไม่มีสะดุด',
                'category_img' => 'https://via.placeholder.com/1080x566.png/ffffff?text='.'Notebook',
            ],
            [
                'name' => 'Smartphone and accessories',
                'description' => 'จำหน่ายสินค้า โทรศัพท์มือถือและอุปกรณ์เสริม',
                'category_img' => 'https://via.placeholder.com/1080x566.png/ffffff?text='.'Smartphone and accessories',
            ],
            [
                'name' => 'Home Appliances',
                'description' => 'จำหน่ายอุปกรณ์ เครื่องใช้ไฟฟ้าในบ้าน สินค้าหลากหลายรูปแบบทั้ง สมาร์ททีวี เครื่องใช้ในครัว เครื่องฟอกอากาศ เครื่องควบคุมอุปกรณ์ภายในบ้าน กล้องวงจรปิด เครื่องดูดฝุ่น และอีกมากมายรวบรวมจากแบรนด์ดังชั้นนำ',
                'category_img' => 'https://via.placeholder.com/1080x566.png/ffffff?text='.'Home Appliances',
            ],
            [
                'name' => 'Computer Hardware',
                'description' => 'จำหน่ายชิ้นส่วนอุปกรณ์คอมพิวเตอร์ประกอบ (DIY PC) ทั้ง Computer Hardware CPU Mainboard RAM SSD การ์ดจอ Case Monitor (หน้าจอคอม) Harddisk สำหรับประกอบคอม จัดสเปกคคอมให้ตรงตามการใช้งาน และอุปกรณ์คอมพิวเตอร์เสริมต่างๆ ไม่ว่าจะเป็น เมาส์ คีย์บอร์ด ในราคาสุดคุ้มหลากหลายประเภทจากแบรนด์ดัง เพื่อตอบโจทย์ทั้งผู้ใช้งานทั่วไปและเหล่าเกมเมอร์ คอมพิวเตอร์ทำงาน ออฟฟิศ คอมพิวเตอร์สำหรับตัดต่อวิดีโอ คอมพิวเตอร์สำหรับงานสตรีมมิ่ง คอมพิวเตอร์สำหรับสายเกมเมอร์ ของแท้ มีบริการหลังการขายเพื่อให้คุณมั่นใจในการใช้งาน อีกทั้งสินค้าทุกประเภทมีการรับประกันทุกชิ้น',
                'category_img' => 'https://via.placeholder.com/1080x566.png/ffffff?text='.'Computer Hardware',
            ],
            [
                'name' => 'Tablet and accessories',
                'description' => 'จำหน่ายสินค้า แท็บเล็ต (Tablet) ใช้งานง่าย เหมาะกับทุกการใช้งาน เรียน เล่น ทำงาน พกพาสะดวก มี Tablet ให้เลือกหลายแบรนด์ หลายยี่ห้อ อาทิ Samsung, Huawei, Lenovo, Microsoft Surface, Acer, Oppo พร้อมอุปกรณ์เสริมแท็บเล็ต มีให้เลือกครบทุกรุ่น แท็บเล็ตราคาถูกพร้อมโปรโมชัน ของแท้ มีการรับประกันสินค้า ทั้งคีย์บอร์ด, เมาส์, ปากกา surface, สายชาร์จ, ฟิล์ม, เคส และอะแดปเตอร์ต่างๆ ทำให้คุณใช้งานแท็บเล็ตได้สะดวกขึ้น สามารถสั่งสินค้าออนไลน์ได้ง่ายๆ ในราคาพิเศษ',
                'category_img' => 'https://via.placeholder.com/1080x566.png/ffffff?text='.'Tablet and accessories',

            ],
            [
                'name' => 'Gaming gear',
                'description' => 'จำหน่ายสินค้า อุปกรณ์เกมมิ่งเกียร์ (Gaming gear),จอยเกม, เมาส์เกมมิ่ง, หูฟังเกมมิ่ง, คีย์บอร์ด, แผ่นเกม, เครื่อง PS5, Nintendo Switch-H, oculus quest 2 ทั้ง Lite Model และ Oled Model สามารถสั่งสินค้าออนไลน์ได้ง่ายๆ ในราคาพิเศษ พร้อมบริการจัดส่งทั่วประเทศ ที่ตอบโจทย์ทุกความต้องการของคุณ',
                'category_img' => 'https://via.placeholder.com/1080x566.png/ffffff?text='.'Gaming gear',
            ],
            [
                'name' => 'Camera',
                'description' => 'จำหน่ายสินค้าและอุปกรณ์ทั้งหมดที่ใช้ผลิตสื่อทั้งภาพและเสียง อย่างเช่น กล้องวิดีโอ, ไมค์ไวเลส, ไมค์ไร้สาย, อุปกรณ์สตรีมมิ่ง Streaming, กล้องถ่ายรูป, ถ่ายภาพ, ฟิล์ม, อุปกรณ์กล้อง, กล้อง Fujifilm, อุปกรณ์ไลฟ์สด แคสเกม Live Facebook มีให้คุณเลือกซื้ออย่างมากมาย ครบจบที่เดียว สามารถสั่งสินค้าออนไลน์ได้ง่ายๆ พร้อมราคาพิเศษจากร้านบานาน่า ที่ตอบโจทย์ทุกความต้องการของคุณ ',
                'category_img' => 'https://via.placeholder.com/1080x566.png/ffffff?text='.'Camera',

            ],
            [
                'name' => 'Desktop and all in one',
                'description' => 'จำหน่ายสินค้า คอมครบชุด คอมพิวเตอร์ตั้งโต๊ะ Desktop คอมพิวเตอร์ออลอินวัน All in one คอมพิวเตอร์เดสก์ท็อปสำหรับเกมมิ่ง  มินิพีซี รวมไปถึง คอมพิวเตอร์เซต สเปคแรงสเปคดี ในราคาที่เหมาะสมกับการใช้งานได้ทุกรูปแบบ ราคาถูก พร้อมวินโดว์  หลากหลายรุ่นภายใต้แบรนด์ชั้นนำทั่วโลก พร้อมโปรโมชั่นสุดพิเศษ อาทิ Acer, Asus, Dell, HP Compaq, Lenovo และแบรนด์อื่นๆ พร้อมบริการจัดส่งทั่วประเทศ ที่ตอบโจทย์ทุกความต้องการของคุณ ',
                'category_img' => 'https://via.placeholder.com/1080x566.png/ffffff?text='.'Desktop and all in one',

            ],
            [
                'name' => 'Home entertainment',
                'description' => 'จำหน่ายสินค้าเพื่อความบันเทิง อย่างเช่น สมาร์ททีวี ภายใต้แบรนด์ชั้นนำทั่วโลก อาทิ SAMSUNG, LG, PANASONIC, SHARP, SONY และแบรนด์อื่นๆ อีกมากมาย แถมยังมีสินค้าลำโพง และ หูฟัง ที่มีให้เลือกหลากหลายรูปแบบ สามารถสั่งสินค้าออนไลน์ได้ง่ายๆ ในราคาพิเศษ',
                'category_img' => 'https://via.placeholder.com/1080x566.png/ffffff?text='.'Home entertainment',

            ],
            [
                'name' => 'IT accessories',
                'description' => 'จำหน่ายอุปกรณ์เสริมไอทีของแท้ มีคุณภาพ อย่างเช่น Card Reader, ปลั๊กพ่วง, USB Hub, Flshdrive, Harddisk, Memory card และ Numpad เป็นต้น ลงตัวทั้งเรื่องของคุณภาพและราคา สามารถสั่งสินค้าออนไลน์ได้ง่ายๆ ในราคาพิเศษ',
                'category_img' => 'https://via.placeholder.com/1080x566.png/ffffff?text='.'IT accessories',

            ],
            [
                'name' => 'Sport health and gadgets',
                'description' => 'จำหน่ายอุปกรณ์ออกกำลังกายและอุปกรณ์เพื่อสุขภาพ ไม่ว่าจะเป็น Smart Watch เครื่องวัดความดัน อุปกรณ์ฆ่าเชื้อ  เพื่อให้คุณได้ดูแลสุขภาพอย่างใกล้ชิด อุปกรณ์สำหรับการทำกิจกรรม ไลฟ์สไตล์และแก็ดเจ็ต ฯลฯ ไม่ว่าจะเป็นกลางแจ้งหรือในร่ม ครบจบที่เดียว สามารถสั่งสินค้าออนไลน์ได้ง่ายๆ ในราคาพิเศษ',
                'category_img' => 'https://via.placeholder.com/1080x566.png/ffffff?text='.'Sport health and gadgets',

            ],
            [
                'name' => 'Network',
                'description' => 'จำหน่ายอุปกรณ์เน็ตเวิร์คที่สามารถส่งผ่านข้อมูลได้อย่างเต็มประสิทธิภาพ ไม่มีสะดุด ช่วยให้ทุกข้อมูลถึงปลายทางได้อย่างราบรื่น ด้วยราคาอุปกรณ์เน็ตเวิร์คแบบย่อมเยา ไม่ว่าจะเป็นอุปกรณ์ที่ใช้กันแพร่หลายที่สุดอย่าง เราเตอร์ (Router), อุปกรณ์ขยายสัญญาณ, Network, สาย LAN, อุปกรณ์ต่อพ่วง และอื่นๆ อีกมากมาย สามารถสั่งสินค้าออนไลน์ได้ง่ายๆ ในราคาพิเศษ',
                'category_img' => 'https://via.placeholder.com/1080x566.png/ffffff?text='.'Network',

            ],
        ];

        foreach ($categories as $category) {
            Category::factory()->create($category);
        }

    }
}
