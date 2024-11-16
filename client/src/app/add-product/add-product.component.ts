import { ToastrService } from 'ngx-toastr';
import { Component, EventEmitter, Input, Output } from '@angular/core';
import { ApiService } from '../api/api.service';
import {FormGroup, FormControl, ReactiveFormsModule} from '@angular/forms';
import { NgClass } from '@angular/common';

@Component({
  selector: 'app-add-product',
  standalone: true,
  imports: [ReactiveFormsModule, NgClass ],
  templateUrl: './add-product.component.html',
  styleUrl: './add-product.component.css'
})
export class AddProductComponent {
  @Input() popUp !: boolean;
  @Output() hide = new EventEmitter<boolean>();
  productInfo = new FormGroup({
    product_name : new FormControl('') ,
    product_desc : new FormControl('') ,
    product_price : new FormControl('') ,
    discount : new FormControl('') ,
    quantity : new FormControl('') ,
    thumbnail : new FormControl('')
  })
  img: any;

  getImage(event : any) {
   this.img = event.target.files[0];
  }

constructor(private product : ApiService , private toastr : ToastrService){}
addProduct(){
  let data = new FormData();
    data.append('product_name' , this.productInfo.get('product_name')?.value as string);
    data.append('product_desc' , this.productInfo.get('product_desc')?.value as string);
    data.append('product_price' , this.productInfo.get('product_price')?.value as string);
    data.append('discount' , this.productInfo.get('discount')?.value as string);
    data.append('quantity' , this.productInfo.get('quantity')?.value as string);
    data.append('thumbnail' , this.img , this.img.name);
this.product.createProduct(data).subscribe({
next : (e : any)=> {
  this.toastr.success(e.message as string)
  this.popUp = false
  this.hide.emit(this.popUp);
  this.productInfo.get('product_name')?.setValue('');
  this.productInfo.get('product_desc')?.setValue('');
  this.productInfo.get('product_price')?.setValue('');
  this.productInfo.get('discount')?.setValue('');
  this.productInfo.get('quantity')?.setValue('');
  this.productInfo.get('thumbnail')?.setValue('');
  console.log(this.productInfo);
},
error : (e : any)=> this.toastr.error(e.error as string)
});

}


hidePopUp(){
  this.popUp = false
  this.hide.emit(this.popUp);
}
}
