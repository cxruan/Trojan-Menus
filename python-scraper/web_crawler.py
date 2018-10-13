from urllib import request
from bs4 import BeautifulSoup
import json

with request.urlopen('https://hospitality.usc.edu/residential-dining-menus/') as menus:
    data = menus.read()

    # print status of request in console
    print('Status:', menus.status, menus.reason)
    for k, v in menus.getheaders():
        print('%s: %s' % (k, v))
    
    # # print html in console
    # print("--------" + '\n')
    # print('Data:', data.decode('utf-8'))]

    # # write output in output.txt file
    # with open("output.txt", "w") as newFile:
    #     newFile.write('Status: 0' + str(menus.status) + ' ' + str(menus.reason) + '\n')
    #     for k, v in menus.getheaders():
    #         newFile.write(str(k) + ': ' + str(v)+ '\n')
    #     newFile.write('----------' + '\n')
    #     newFile.write(data.decode('utf-8'))

soup = BeautifulSoup(data.decode('utf-8'),'html.parser')
diningHall = soup.find_all("h3", class_="menu-venue-title")
bar = diningHall.find
with open("filtered.txt", "w") as newFile:
    for item in diningHall:
        newFile.write(str(item) + '\n')


menu = soup.find_all("ul", class_="menu-item-list")
# with open("filtered.txt", "w") as newFile:
#     for item in menu:
#         newFile.write(str(item) + '\n')