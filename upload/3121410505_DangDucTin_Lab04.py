import mysql.connector
import datetime

def connector_mysql() :
    connection=mysql.connector.connect(
        host='localhost',
        user='root',
        password=''
    )
    return connection
def create_database(db):
    con=connector_mysql()
    cursor=con.cursor()
    cursor.execute('create database if not exists ' +db)
    cursor.execute('use '+db)
    print('Cơ sở dữ liệu là: ', db)
    cursor.execute('create table if not exists employee(employeeeid varchar(10) primary key, fullname varchar(100), birthday date, phone varchar(100)) ')
    return con
def insert(id, name, birthday, phone, con):
        cursor = con.cursor()
        cursor.execute("insert into employee values (%s, %s, %s, %s) ", (id,name,birthday,phone))
        con.commit()
        cursor.close()
def delete_employee(id,con):
    cursor = con.cursor()
    count = cursor.execute("delete from employee where employee=%s", (id,))
    con.commit()
    cursor.close()
    if(count > 0):
        print("Xóa thành công")
    else:
        print("Mã không tồn tại ")

def show_all(con):
    cursor = con.cursor()
    cursor.execute("SELECT * FROM employee")
    records = cursor.fetchall()
    print("---------------DANH SÁCH NHÂN VIÊN ------------------")
    for r in records:
        print(r[0], "\t", r[1], "\t", r[2], "\t", r[3])
    cursor.close()
def input_employee(con):
    print("------------- DANH SÁCH NHÂN VIÊN -----------------")
    while True:
        id = input("Mã nhân viên: ")
        name = input("Tên nhân viên: ")
        birthday = datetime.datetime.strptime(input("Ngày sinh: dd/mm/yyyy: "), "%d/%m/%Y")
        phone = input("Điện thoại: ")
        insert(id, name, birthday, phone, con)
        choose = input("Bạn có muốn tiếp tục không ? y/n: ")
        if choose.lower() == 'n':
            break
        print("--------------------------------------------------")



def edit_employee(id, con):
    cursor = con.cursor()
    cursor.execute("SELECT * FROM employee WHERE employeeeid = %s", (id,))
    employee = cursor.fetchone()
    cursor.close()

    if employee:
        print("Thông tin hiện tại của nhân viên:")
        print("Mã nhân viên:", employee[0])
        print("Họ và tên:", employee[1])
        print("Ngày sinh:", employee[2]) # Chuyển đổi định dạng ngày tháng
        print("Số điện thoại:", employee[3])

        new_name = input("Nhập tên mới: ")
        new_birthday = datetime.datetime.strptime(input("Nhập ngày sinh mới (dd/mm/yyyy): "), "%d/%m/%Y") # Sử dụng định dạng dd/mm/yyyy
        new_phone = input("Nhập số điện thoại mới: ")

        cursor = con.cursor()
        cursor.execute("UPDATE employee SET fullname = %s, birthday = %s, phone = %s WHERE employeeeid = %s", (new_name, new_birthday, new_phone, id))
        con.commit()
        cursor.close()
        print("Cập nhật thông tin nhân viên thành công")
    else:
        print("Không tìm thấy nhân viên có mã", id)

def search_employee_by_name(name, con):
    cursor = con.cursor()
    cursor.execute("SELECT * FROM employee WHERE fullname LIKE %s", ('%' + name + '%',))
    records = cursor.fetchall()
    if len(records) == 0:
        print("Không tìm thấy nhân viên có tên:", name)
    else:
        print("---------------KẾT QUẢ TÌM KIẾM ------------------")
        for r in records:
            print(r[0], "\t", r[1], "\t", r[2], "\t", r[3])
    cursor.close()

con = create_database('lab4_1')
while(True):
    print("1. Nhập nhân viên")
    print("2. Hiển thị tất cả nhân viên")
    print("3. Xóa nhân viên")
    print("4. Sửa nhân viên")
    print("5. Tìm kiếm theo tên")
    print("6. Thoát")
    choose = input("Chọn 1 chức năng: ")
    if(choose == "1"):
        input_employee(con)
    elif (choose == "2"):
        show_all(con)
    elif (choose == "3"):
        id=input("Nhập mã cần xóa: ")
        delete_employee(id,con)
    elif (choose == "4"):
        id=input("Nhập mã cần sửa: ")
        edit_employee(id,con)
    elif (choose == "5"):
        name=input("Nhập tên cần tìm kiếm: ")
        search_employee_by_name(name,con)
    elif (choose == "6"):
        break
    else: print("Bạn chọn sai rồi")
print("Kết thúc chương trình")



