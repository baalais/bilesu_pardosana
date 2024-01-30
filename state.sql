-- Lietotāji
CREATE TABLE Users (
    UserID INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(50) NOT NULL,
    PasswordHash VARCHAR(255) NOT NULL
);

-- Pasākumi
CREATE TABLE Events (
    EventID INT PRIMARY KEY AUTO_INCREMENT,
    EventName VARCHAR(100) NOT NULL,
    EventDate DATE NOT NULL,
    EventTime TIME NOT NULL,
    TicketType VARCHAR(50) NOT NULL,
    Venue VARCHAR(100) NOT NULL,
    TicketPrice DECIMAL(10, 2) NOT NULL
);

-- Biļetes
CREATE TABLE Tickets (
    TicketID INT PRIMARY KEY AUTO_INCREMENT,
    EventID INT,
    UserID INT,
    Quantity INT NOT NULL,
    Price DECIMAL(10, 2) NOT NULL,
    CONSTRAINT fk_Event FOREIGN KEY (EventID) REFERENCES Events(EventID),
    CONSTRAINT fk_User FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

-- Atsauksmes
CREATE TABLE Reviews (
    ReviewID INT PRIMARY KEY AUTO_INCREMENT,
    EventID INT,
    UserID INT,
    Rating INT NOT NULL,
    Comment TEXT,
    CONSTRAINT fk_EventReview FOREIGN KEY (EventID) REFERENCES Events(EventID),
    CONSTRAINT fk_UserReview FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

-- Biļešu saglabāšana
CREATE TABLE SavedTickets (
    SavedTicketID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    TicketID INT,
    PDFPath VARCHAR(255) NOT NULL,
    CONSTRAINT fk_UserSavedTicket FOREIGN KEY (UserID) REFERENCES Users(UserID),
    CONSTRAINT fk_TicketSavedTicket FOREIGN KEY (TicketID) REFERENCES Tickets(TicketID)
);

-- Pirkumu vēsture
CREATE TABLE PurchaseHistory (
    PurchaseID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    TicketID INT,
    PurchaseDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_UserPurchase FOREIGN KEY (UserID) REFERENCES Users(UserID),
    CONSTRAINT fk_TicketPurchase FOREIGN KEY (TicketID) REFERENCES Tickets(TicketID)
);
