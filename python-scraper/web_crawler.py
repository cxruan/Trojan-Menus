from urllib import request
from bs4 import BeautifulSoup
import re
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

# search for separate html category
meals = soup.find_all(class_="hsp-accordian-container")
diningHalls = []
bars = []
for i_meal in range(len(meals)):
    diningHalls.append(meals[i_meal].find_all(class_="col-sm-6 col-md-4"))
    bars.append([])
    for i_diningHall in range(len(diningHalls[i_meal])):
        if diningHalls[i_meal][i_diningHall].find(class_="menu-item-list"):
            bars[i_meal].append(diningHalls[i_meal][i_diningHall].find_all(class_="menu-item-list"))
        else:
            bars[i_meal].append([])

# # write the filtered html in filtered.txt [DEBUG]
# with open("filtered.txt", "w") as newFile:
#     for meal in meals:
#         newFile.write(str(meal) + '\n')
#         for diningHall in diningHalls[meals.index(meal)]:
#             newFile.write('\t' + str(diningHall) + '\n')
#             if (len(bars[meals.index(meal)][diningHalls[meals.index(meal)].index(diningHall)]) != 0):
#                 for bar in bars[meals.index(meal)][diningHalls[meals.index(meal)].index(diningHall)]:
#                     newFile.write('\t\t' + str(bar) + '\n')
#             else:
#                 newFile.write('\t\t' + 'Null' + '\n')

# search for separate dish tags
dishes = []
for meal in meals:
    dishes.append([])
    for diningHall in diningHalls[meals.index(meal)]:
        if diningHall.find(class_="menu-item-list"):
            dishes[meals.index(meal)].append([])
            for bar in bars[meals.index(meal)][diningHalls[meals.index(meal)].index(diningHall)]:
                dishes[meals.index(meal)][diningHalls[meals.index(meal)].index(diningHall)].append(bar.find_all("li"))

# search for separate bar tags
bars = []
for meal in meals:
    bars.append([])
    for diningHall in diningHalls[meals.index(meal)]:
        if (diningHall.find(class_="menu-item-list")):         
            bars[meals.index(meal)].append(diningHall.find_all("h4"))
        else:
            bars[meals.index(meal)].append("Null")

# search for separate diningHall tags
diningHalls = []
for meal in meals:
    diningHalls.append(meal.find_all(class_="menu-venue-title"))

# search for separate meal tags
meals = soup.find_all(class_="fw-accordion-title-inner")

# write the filtered menu in filtered.txt
with open("filtered.txt", "w") as newFile:
    for meal in meals:
        newFile.write(meal.get_text().split()[0] + '\n')
        for diningHall in diningHalls[meals.index(meal)]:
            newFile.write('\t' + diningHall.get_text() + '\n')
            if (type(bars[meals.index(meal)][diningHalls[meals.index(meal)].index(diningHall)]) == type(meals)):
                for bar in bars[meals.index(meal)][diningHalls[meals.index(meal)].index(diningHall)]:
                    newFile.write('\t\t' + bar.get_text() + '\n')
                    for dish in dishes[meals.index(meal)][diningHalls[meals.index(meal)].index(diningHall)][bars[meals.index(meal)][diningHalls[meals.index(meal)].index(diningHall)].index(bar)]:
                        newFile.write('\t\t\t' + str(dish)[4: re.compile(r"(?<=<li>)[^<]+(?=<span)").search(str(dish)).end()] + '\n')
            else:
                newFile.write('\t\t' + bars[meals.index(meal)][diningHalls[meals.index(meal)].index(diningHall)] + '\n')